<?php

namespace App\Http\Controllers;

use App\Enums\ExchangeStatus;
use App\Enums\ExchangeType;
use App\Enums\ItemStatus;
use App\Models\Exchange;
use App\Models\Item;
use App\Services\ExchangeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ExchangeController extends Controller
{
    /**
     * List the authenticated user's received and sent requests.
     */
    public function index(Request $request): View
    {
        $userId = $request->user()->id;
        $status = in_array($request->query('status'), array_column(ExchangeStatus::cases(), 'value'))
            ? $request->query('status')
            : 'ALL';

        $received = Exchange::with(['requester', 'requestedItem.images', 'offeredItem.images'])
            ->whereHas('requestedItem', fn ($query) => $query->where('user_id', $userId))
            ->when($status !== 'ALL', fn ($query) => $query->where('status', $status))
            ->latest()
            ->get();

        $sent = Exchange::with(['requestedItem.user', 'requestedItem.images', 'offeredItem.images'])
            ->where('requester_id', $userId)
            ->when($status !== 'ALL', fn ($query) => $query->where('status', $status))
            ->latest()
            ->get();

        $tab = $request->query('tab') === 'sent' ? 'sent' : 'received';

        return view('exchanges.index', [
            'received' => $received,
            'sent' => $sent,
            'tab' => $tab,
            'status' => $status,
        ]);
    }

    /**
     * Show the form to request an item.
     */
    public function create(Request $request): View
    {
        $item = Item::findOrFail($request->query('item'));

        return view('exchanges.create', [
            'item' => $item,
            'myItems' => $request->user()->items()->where('status', ItemStatus::AVAILABLE)->get(),
        ]);
    }

    /**
     * Submit a request for an item.
     */
    public function store(Request $request, ExchangeService $exchanges): RedirectResponse
    {
        $validated = $request->validate([
            'item_id' => ['required', 'exists:items,id'],
            'type' => ['required', Rule::enum(ExchangeType::class)],
            'offered_item_id' => ['nullable', 'exists:items,id'],
            'message' => ['nullable', 'string', 'max:255'],
        ]);

        $item = Item::findOrFail($validated['item_id']);

        $offeredItem = ($validated['offered_item_id'] ?? null)
            ? $request->user()->items()->findOrFail($validated['offered_item_id'])
            : null;

        $exchanges->create($request->user(), $item, $validated['type'], $offeredItem, $validated['message'] ?? null);

        return redirect()->route('exchanges.index')->with('status', 'exchange-requested');
    }

    /**
     * Show a single request's detail.
     */
    public function show(Request $request, Exchange $exchange): View
    {
        $this->authorizeParticipant($request, $exchange);

        $exchange->load(['requester', 'requestedItem.user', 'requestedItem.images', 'offeredItem.images']);

        return view('exchanges.show', ['exchange' => $exchange]);
    }

    /**
     * Move a request to a new status (accept, reject or finish).
     */
    public function update(Request $request, Exchange $exchange, ExchangeService $exchanges): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in([
                ExchangeStatus::ACCEPTED->value,
                ExchangeStatus::REJECTED->value,
                ExchangeStatus::FINISHED->value,
            ])],
        ]);

        match ($validated['status']) {
            ExchangeStatus::ACCEPTED->value => $exchanges->accept($exchange, $request->user()),
            ExchangeStatus::REJECTED->value => $exchanges->reject($exchange, $request->user()),
            ExchangeStatus::FINISHED->value => $exchanges->finish($exchange, $request->user()),
        };

        return redirect()->route('exchanges.index')->with('status', 'exchange-'.strtolower($validated['status']));
    }

    /**
     * Cancel a pending request I sent.
     */
    public function destroy(Request $request, Exchange $exchange, ExchangeService $exchanges): RedirectResponse
    {
        $exchanges->cancel($exchange, $request->user());

        return redirect()->route('exchanges.index')->with('status', 'exchange-cancelled');
    }

    private function authorizeParticipant(Request $request, Exchange $exchange): void
    {
        $userId = $request->user()->id;

        abort_unless($exchange->requester_id === $userId || $exchange->requestedItem->user_id === $userId, 403);
    }
}
