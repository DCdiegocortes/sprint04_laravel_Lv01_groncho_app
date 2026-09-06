@php
    $images = $universe->images;
@endphp

<x-app-layout>
    <x-slot name="header">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-1">{{ __('004 — Universe') }}</p>
        <h2 class="font-bold tracking-tight text-2xl text-ink leading-tight">
            {{ $universe->name }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl overflow-hidden bg-paper shadow-neu-card">
                <div class="relative h-40" style="background: linear-gradient(135deg, #C8C8C6, #E6E6E4);"></div>

                <div class="px-6 -mt-8 relative pb-6">
                    <div class="w-16 h-16 rounded-xl flex items-center justify-center mb-4 bg-paper shadow-neu-subtle" style="border: 4px solid #E6E6E4;">
                        <span class="font-mono text-lg text-ink">{{ strtoupper(substr($owner->name, 0, 1)) }}</span>
                    </div>

                    <p class="font-mono text-[10px] text-muted mb-1">{{ $owner->name }}</p>

                    @if ($universe->style)
                        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted">{{ $universe->style }}</p>
                    @endif
                    <h3 class="text-2xl font-bold tracking-[-0.02em] leading-tight mt-2 mb-2 text-ink">{{ $universe->name }}</h3>

                    @if ($universe->description)
                        <p class="text-sm leading-relaxed mb-6 text-muted">{{ $universe->description }}</p>
                    @endif

                    <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-3">{{ __('Moodboard') }}</p>

                    @if ($images->isNotEmpty())
                        <div class="columns-2 sm:columns-3 gap-3 [&>*]:mb-3 [&>*]:break-inside-avoid">
                            @foreach ($images as $image)
                                <img src="{{ asset('storage/'.$image->path) }}" alt="" class="w-full rounded-2xl shadow-neu-card">
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-muted">{{ __('No photos yet.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
