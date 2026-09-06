<x-app-layout>
    <x-slot name="header">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-1">{{ __('005 — Wardrobe') }}</p>
        <div class="flex items-center justify-between">
            <h2 class="font-bold tracking-tight text-2xl text-ink leading-tight">
                {{ __('My items') }}
            </h2>
            <a href="{{ route('items.create') }}" class="inline-flex items-center py-2.5 px-5 bg-accent rounded-full font-semibold text-xs text-white tracking-[0.05em] shadow-neu-accent active:shadow-neu-inset active:scale-[0.98] transition ease-in-out duration-150">
                {{ __('+ Add item') }}
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                $statusMessages = [
                    'item-created' => __('Item added.'),
                    'item-updated' => __('Item updated.'),
                    'item-deleted' => __('Item deleted.'),
                ];
            @endphp
            @if (session('status') && isset($statusMessages[session('status')]))
                <p class="font-mono text-[10px] text-accent mb-4">{{ $statusMessages[session('status')] }}</p>
            @endif

            @if ($items->isEmpty())
                <div class="rounded-2xl bg-paper shadow-neu-card p-6 flex items-center justify-between">
                    <p class="text-sm text-muted">{{ __("You haven't added any items yet.") }}</p>
                    <a href="{{ route('items.create') }}" class="inline-flex items-center py-3 px-5 bg-accent rounded-full font-semibold text-sm text-white tracking-[0.05em] shadow-neu-accent">
                        {{ __('Add your first item') }}
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach ($items as $item)
                        <a href="{{ route('items.edit', $item) }}" class="block rounded-2xl overflow-hidden bg-paper shadow-neu-card active:shadow-neu-inset transition ease-in-out duration-150">
                            @if ($item->images->isNotEmpty())
                                <img src="{{ asset('storage/'.$item->images->first()->path) }}" alt="" class="w-full aspect-[3/4] object-cover">
                            @else
                                <div class="w-full aspect-[3/4]" style="background-color: #D4D4D2;"></div>
                            @endif
                            <div class="p-3">
                                <p class="text-[11px] font-semibold leading-tight mb-2 text-ink">{{ $item->title }}</p>
                                <p class="font-mono text-[9px] text-muted mb-2">{{ $item->size ?? '—' }} / {{ $item->item_condition->label() }}</p>
                                <span class="inline-flex items-center px-2 py-[3px] rounded-sm font-mono text-[9px] font-semibold tracking-[0.1em] text-muted bg-ink/[0.06]">
                                    {{ strtoupper($item->offer_type->label()) }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
