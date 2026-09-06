@php
    $universe = auth()->user()->universe;
    $items = auth()->user()->items;
    $images = $universe?->images;
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
                                    <p class="text-xl font-normal tracking-tight text-ink font-mono">{{ str_pad($stat['value'], 3, '0', STR_PAD_LEFT) }}</p>
                                    <p class="text-[8px] mt-0.5 text-muted font-mono tracking-[0.14em]">{{ $stat['label'] }}</p>
                                </div>
                            @endforeach
                        </div>

                        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-3">{{ __('Moodboard') }}</p>

                        <form method="post" action="{{ route('universe.images.store') }}" enctype="multipart/form-data" class="mb-4">
                            @csrf
                            <div class="rounded-2xl p-6 bg-paper shadow-neu-inset flex flex-col items-center gap-2 text-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-paper shadow-neu-subtle">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 17a4 4 0 100-8 4 4 0 000 8z" />
                                    </svg>
                                </div>
                                <p class="font-mono uppercase tracking-[0.14em] text-[10px] text-muted">
                                    {{ __('Add photos') }}
                                </p>
                                <p class="font-mono text-[9px] text-muted/70">{{ __('JPG, PNG · up to 10MB each') }}</p>
                                <input id="images" name="images[]" type="file" accept="image/png,image/jpeg" multiple class="sr-only peer" />
                                <label for="images" class="mt-2 inline-flex items-center justify-center py-2.5 px-5 bg-paper rounded-full font-semibold text-xs text-ink tracking-[0.05em] shadow-neu-raised cursor-pointer active:shadow-neu-inset active:scale-[0.98] transition ease-in-out duration-150">
                                    {{ __('Choose files') }}
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('images')" class="mt-2" />
                            <x-input-error :messages="$errors->get('images.0')" class="mt-2" />
                            <x-primary-button class="mt-3 !py-2.5 !px-5 !text-xs">
                                {{ __('Upload') }}
                            </x-primary-button>
                        </form>

                        @if ($images && $images->isNotEmpty())
                            <div class="columns-2 sm:columns-3 gap-3 mb-8 [&>*]:mb-3 [&>*]:break-inside-avoid">
                                @foreach ($images as $image)
                                    <img src="{{ asset('storage/'.$image->path) }}" alt="" class="w-full rounded-2xl shadow-neu-card">
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-muted mb-8">{{ __('No photos yet.') }}</p>
                        @endif

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
