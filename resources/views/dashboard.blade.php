@php
    $universe = auth()->user()->universe;
    $items = auth()->user()->items;
@endphp

<x-app-layout>
    <x-slot name="header">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-1">{{ __('001 — Home') }}</p>
        <h2 class="font-bold tracking-tight text-2xl text-ink leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($universe)
                <div class="rounded-2xl overflow-hidden bg-paper shadow-neu-card">
                    <div class="relative h-40" style="background: linear-gradient(135deg, #C8C8C6, #E6E6E4);"></div>

                    <div class="px-6 -mt-8 relative pb-6">
                        <div class="w-16 h-16 rounded-xl flex items-center justify-center mb-4 bg-paper shadow-neu-subtle" style="border: 4px solid #E6E6E4;">
                            <span class="font-mono text-lg text-ink">{{ strtoupper(substr($universe->name, 0, 1)) }}</span>
                        </div>

                        @if ($universe->style)
                            <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted">{{ $universe->style }}</p>
                        @endif
                        <h3 class="text-2xl font-bold tracking-[-0.02em] leading-tight mt-2 mb-2 text-ink">{{ $universe->name }}</h3>

                        @if ($universe->description)
                            <p class="text-sm leading-relaxed mb-6 text-muted">{{ $universe->description }}</p>
                        @endif

                        <div class="flex gap-3 mb-8">
                            @foreach ([['value' => $items->count(), 'label' => 'ITEMS'], ['value' => 0, 'label' => 'MATCHES'], ['value' => 0, 'label' => 'SWAPS']] as $stat)
                                <div class="flex-1 flex flex-col items-center py-3 rounded-2xl bg-paper shadow-neu-card">
                                    <p class="text-xl font-semibold tracking-tight text-ink font-mono">{{ str_pad($stat['value'], 3, '0', STR_PAD_LEFT) }}</p>
                                    <p class="text-[8px] mt-0.5 text-muted font-mono tracking-[0.14em]">{{ $stat['label'] }}</p>
                                </div>
                            @endforeach
                        </div>

                        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-3">{{ __('Wardrobe') }}</p>

                        @if ($items->isEmpty())
                            <p class="text-sm text-muted">{{ __('No items yet.') }}</p>
                        @else
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                                @foreach ($items as $item)
                                    <div class="rounded-2xl overflow-hidden bg-paper shadow-neu-card">
                                        <div class="w-full aspect-[3/4]" style="background-color: #D4D4D2;"></div>
                                        <div class="p-3">
                                            <p class="text-[11px] font-semibold leading-tight mb-2 text-ink">{{ $item->title }}</p>
                                            <span class="inline-flex items-center px-2 py-[3px] rounded-sm font-mono text-[9px] font-semibold tracking-[0.1em] text-muted bg-ink/[0.06]">
                                                {{ strtoupper($item->offer_type) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="rounded-2xl bg-paper shadow-neu-card p-6 flex items-center justify-between">
                    <p class="text-sm text-muted">{{ __("You haven't created your universe yet.") }}</p>
                    <a href="{{ route('universe.create') }}" class="inline-flex items-center py-3 px-5 bg-accent rounded-full font-semibold text-sm text-white tracking-[0.05em] shadow-neu-accent">
                        {{ __('Create universe') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
