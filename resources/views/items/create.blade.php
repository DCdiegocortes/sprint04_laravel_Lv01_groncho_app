@php
    $conditions = ['NEW' => 'New', 'EXCELLENT' => 'Excellent', 'GOOD' => 'Good', 'FAIR' => 'Fair'];
    $types = ['CLOTHES' => 'Clothes', 'ACCESSORIES' => 'Accessories'];
    $offerTypes = ['TRADE' => 'Trade', 'GIFT' => 'Gift', 'BOTH' => 'Trade or gift'];
@endphp

<x-app-layout>
    <x-slot name="header">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-1">{{ __('006 — Wardrobe') }}</p>
        <h2 class="font-bold tracking-tight text-2xl text-ink leading-tight">
            {{ __('Add item') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl bg-paper shadow-neu-card p-6">
                <form method="post" action="{{ route('items.store') }}" enctype="multipart/form-data" class="flex flex-col gap-7">
                    @csrf

                    <div class="flex flex-col gap-2">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" :value="old('title')" required autofocus placeholder="{{ __('Linen blazer, size S') }}" />
                        <x-input-error :messages="$errors->get('title')" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="3" class="w-full bg-paper border-0 text-ink placeholder:text-ink/25 shadow-neu-inset focus:ring-0 focus:shadow-neu-inset rounded-xl px-4 py-3 text-sm" placeholder="{{ __('Tell us about this item...') }}">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-input-label for="size" :value="__('Size')" />
                        <x-text-input id="size" name="size" type="text" :value="old('size')" placeholder="{{ __('S, M, 42, one size...') }}" />
                        <x-input-error :messages="$errors->get('size')" />
                    </div>

                    <div class="flex flex-col gap-3">
                        <x-input-label :value="__('Category')" />
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach ($types as $value => $label)
                                <label>
                                    <input type="radio" name="type" value="{{ $value }}" class="peer sr-only" @checked(old('type') === $value)>
                                    <span class="flex items-center justify-center rounded-full px-5 py-2.5 font-mono text-[10px] font-semibold tracking-[0.1em] text-muted shadow-neu-raised peer-checked:text-ink peer-checked:shadow-neu-inset active:shadow-neu-inset active:scale-[0.98] cursor-pointer transition-all">
                                        {{ strtoupper($label) }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('type')" />
                    </div>

                    <div class="flex flex-col gap-3">
                        <x-input-label :value="__('Condition')" />
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach ($conditions as $value => $label)
                                <label>
                                    <input type="radio" name="item_condition" value="{{ $value }}" class="peer sr-only" @checked(old('item_condition', 'GOOD') === $value)>
                                    <span class="flex items-center justify-center rounded-full px-5 py-2.5 font-mono text-[10px] font-semibold tracking-[0.1em] text-muted shadow-neu-raised peer-checked:text-ink peer-checked:shadow-neu-inset active:shadow-neu-inset active:scale-[0.98] cursor-pointer transition-all">
                                        {{ strtoupper($label) }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('item_condition')" />
                    </div>

                    <div class="flex flex-col gap-3">
                        <x-input-label :value="__('Offer type')" />
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach ($offerTypes as $value => $label)
                                <label>
                                    <input type="radio" name="offer_type" value="{{ $value }}" class="peer sr-only" @checked(old('offer_type', 'TRADE') === $value)>
                                    <span class="flex items-center justify-center rounded-full px-5 py-2.5 font-mono text-[10px] font-semibold tracking-[0.1em] text-muted shadow-neu-raised peer-checked:text-ink peer-checked:shadow-neu-inset active:shadow-neu-inset active:scale-[0.98] cursor-pointer transition-all">
                                        {{ strtoupper($label) }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('offer_type')" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-input-label :value="__('Photos')" />
                        <div class="rounded-2xl p-6 bg-paper shadow-neu-inset flex flex-col items-center gap-2 text-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-paper shadow-neu-subtle">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 17a4 4 0 100-8 4 4 0 000 8z" />
                                </svg>
                            </div>
                            <p class="font-mono text-[9px] text-muted/70">{{ __('JPG, PNG · up to 10MB each') }}</p>
                            <input id="images" name="images[]" type="file" accept="image/png,image/jpeg" multiple class="sr-only peer" />
                            <label for="images" class="mt-2 inline-flex items-center justify-center py-2.5 px-5 bg-paper rounded-full font-semibold text-xs text-ink tracking-[0.05em] shadow-neu-raised cursor-pointer active:shadow-neu-inset active:scale-[0.98] transition ease-in-out duration-150">
                                {{ __('Choose files') }}
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('images')" />
                        <x-input-error :messages="$errors->get('images.0')" />
                    </div>

                    <x-primary-button class="w-full mt-2">{{ __('Add item') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
