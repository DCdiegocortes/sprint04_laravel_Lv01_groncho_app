@php
    $isOwner = auth()->id() === $item->user_id;
@endphp

<x-app-layout>
    <x-slot name="header">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-1">{{ __('006 — Wardrobe') }}</p>
        <h2 class="font-bold tracking-tight text-2xl text-ink leading-tight">
            {{ $item->title }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl bg-paper shadow-neu-card p-6">
                @if ($item->images->isNotEmpty())
                    @if ($item->images->count() === 1)
                        <div class="flex justify-center mb-6">
                            <img src="{{ asset('storage/'.$item->images->first()->path) }}" alt="" class="max-w-xs w-full rounded-2xl shadow-neu-card">
                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-3 mb-6">
                            @foreach ($item->images as $image)
                                <img src="{{ asset('storage/'.$image->path) }}" alt="" class="w-full aspect-square rounded-2xl object-cover shadow-neu-card">
                            @endforeach
                        </div>
                    @endif
                @endif

                <span class="inline-flex items-center px-2 py-[3px] rounded-sm font-mono text-[9px] font-semibold tracking-[0.1em] text-muted bg-ink/[0.06] mb-3">
                    {{ strtoupper($item->offer_type->label()) }}
                </span>

                <h3 class="text-xl font-bold tracking-[-0.02em] leading-tight mb-2 text-ink">{{ $item->title }}</h3>
                <p class="font-mono text-[10px] text-muted mb-4">{{ $item->size ?? '—' }} / {{ $item->item_condition->label() }}</p>

                @if ($item->description)
                    <p class="text-sm leading-relaxed mb-6 text-muted">{{ $item->description }}</p>
                @endif

                @if ($isOwner)
                    <div class="flex items-center justify-center gap-3">
                        <x-secondary-button type="button" onclick="window.location='{{ route('items.edit', $item) }}'">
                            {{ __('Edit') }}
                        </x-secondary-button>
                    </div>
                @elseif ($isMatched && $item->status === \App\Enums\ItemStatus::AVAILABLE)
                    <div class="flex items-center justify-center gap-3">
                        <x-primary-button type="button" onclick="window.location='{{ route('exchanges.create', ['item' => $item->id]) }}'">
                            {{ __('Request') }}
                        </x-primary-button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
