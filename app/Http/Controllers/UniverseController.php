<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UniverseController extends Controller
{
    /**
     * Show another user's universe, read-only.
     */
    public function show(User $user): View
    {
        abort_unless($user->universe, 404);

        return view('universe.show', ['owner' => $user, 'universe' => $user->universe]);
    }

    /**
     * Show the form to create the authenticated user's universe.
     */
    public function create(Request $request): View|RedirectResponse
    {
        if ($request->user()->universe) {
            return redirect()->route('dashboard');
        }

        return view('universe.create');
    }

    /**
     * Store the authenticated user's universe.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->universe) {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['style'] = $this->resolveStyle($request);

        $request->user()->universe()->create($validated);

        return redirect()->route('dashboard')->with('status', 'universe-created');
    }

    /**
     * Show the form to edit the authenticated user's universe.
     */
    public function edit(Request $request): View|RedirectResponse
    {
        $universe = $request->user()->universe;

        if (! $universe) {
            return redirect()->route('universe.create');
        }

        return view('universe.edit', ['universe' => $universe]);
    }

    /**
     * Update the authenticated user's universe.
     */
    public function update(Request $request): RedirectResponse
    {
        $universe = $request->user()->universe;

        if (! $universe) {
            return redirect()->route('universe.create');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['style'] = $this->resolveStyle($request);

        $universe->update($validated);

        return redirect()->route('dashboard')->with('status', 'universe-updated');
    }

    /**
     * Combine the selected style checkboxes and the free-text style into a single string.
     */
    private function resolveStyle(Request $request): ?string
    {
        $validated = $request->validate([
            'style' => ['nullable', 'array'],
            'style.*' => ['string', 'max:100'],
            'custom_style' => ['nullable', 'string', 'max:100'],
        ]);

        $parts = $validated['style'] ?? [];

        if (filled($validated['custom_style'] ?? null)) {
            $parts[] = $validated['custom_style'];
        }

        if (empty($parts)) {
            return null;
        }

        $style = implode(', ', $parts);

        if (strlen($style) > 100) {
            throw ValidationException::withMessages([
                'style' => __('Too many styles selected — try fewer, the combined text is too long.'),
            ]);
        }

        return $style;
    }
}
