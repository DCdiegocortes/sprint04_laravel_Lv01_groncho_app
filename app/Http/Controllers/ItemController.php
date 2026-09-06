<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ItemController extends Controller
{
    /**
     * List the authenticated user's items.
     */
    public function index(Request $request): View
    {
        return view('items.index', [
            'items' => $request->user()->items()->with('images')->latest()->get(),
        ]);
    }

    /**
     * Show the form to create a new item.
     */
    public function create(): View
    {
        return view('items.create');
    }

    /**
     * Store a new item.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateItem($request);

        $item = $request->user()->items()->create([
            ...$validated,
            'status' => 'AVAILABLE',
        ]);

        $this->storeImages($request, $item);

        return redirect()->route('items.index')->with('status', 'item-created');
    }

    /**
     * Show a single item.
     */
    public function show(Item $item): View
    {
        return view('items.show', ['item' => $item]);
    }

    /**
     * Show the form to edit an item.
     */
    public function edit(Request $request, Item $item): View
    {
        $this->authorizeOwner($request, $item);

        return view('items.edit', ['item' => $item]);
    }

    /**
     * Update an item.
     */
    public function update(Request $request, Item $item): RedirectResponse
    {
        $this->authorizeOwner($request, $item);

        $validated = $this->validateItem($request);

        $item->update($validated);

        $this->storeImages($request, $item);

        return redirect()->route('items.edit', $item)->with('status', 'item-updated');
    }

    /**
     * Delete an item.
     */
    public function destroy(Request $request, Item $item): RedirectResponse
    {
        $this->authorizeOwner($request, $item);

        foreach ($item->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $item->delete();

        return redirect()->route('items.index')->with('status', 'item-deleted');
    }

    /**
     * Delete a single photo from an item.
     */
    public function destroyImage(Request $request, Item $item, ItemImage $itemImage): RedirectResponse
    {
        $this->authorizeOwner($request, $item);
        abort_unless($itemImage->item_id === $item->id, 404);

        Storage::disk('public')->delete($itemImage->path);
        $itemImage->delete();

        return redirect()->route('items.edit', $item)->with('status', 'image-deleted');
    }

    private function authorizeOwner(Request $request, Item $item): void
    {
        abort_unless($item->user_id === $request->user()->id, 403);
    }

    private function validateItem(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:255'],
            'item_condition' => ['required', 'in:NEW,EXCELLENT,GOOD,FAIR'],
            'size' => ['nullable', 'string', 'max:100'],
            'type' => ['required', 'in:CLOTHES,ACCESSORIES'],
            'offer_type' => ['required', 'in:TRADE,GIFT,BOTH'],
        ]);
    }

    private function storeImages(Request $request, Item $item): void
    {
        $validated = $request->validate([
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:10240'],
        ]);

        foreach ($validated['images'] ?? [] as $image) {
            $path = $image->store('item-images', 'public');

            $item->images()->create(['path' => $path]);
        }
    }
}
