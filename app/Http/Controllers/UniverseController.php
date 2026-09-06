<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UniverseController extends Controller
{
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
            'style' => ['nullable', 'string', 'max:100'],
        ]);

        $request->user()->universe()->create($validated);

        return redirect()->route('dashboard')->with('status', 'universe-created');
    }
}
