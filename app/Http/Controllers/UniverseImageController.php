<?php

namespace App\Http\Controllers;

use App\Models\UniverseImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UniverseImageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $universe = $request->user()->universe;

        if (! $universe) {
            return redirect()->route('universe.create');
        }

        $validated = $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['image', 'max:10240'],
        ]);

        foreach ($validated['images'] as $image) {
            $path = $image->store('universe-images', 'public');

            $universe->images()->create([
                'path' => $path,
            ]);
        }

        return redirect()->route('dashboard')->with('status', 'images-uploaded');
    }

    public function destroy(Request $request, UniverseImage $universeImage): RedirectResponse
    {
        if ($universeImage->universe_id !== $request->user()->universe?->id) {
            abort(403);
        }

        Storage::disk('public')->delete($universeImage->path);

        $universeImage->delete();

        return redirect()->route('dashboard')->with('status', 'image-deleted');
    }
}
