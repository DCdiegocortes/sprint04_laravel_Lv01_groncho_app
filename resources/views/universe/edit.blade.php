@php
    $styles = ['MINIMAL / ZEN', 'Y2K / POP', 'DARK ACADEMIA / VINTAGE', 'PARISIAN / ECLECTIC', 'STREETWEAR', 'ROMANTIC / FLORAL', 'AVANT-GARDE', 'BOHO / EARTH', 'PREPPY / OLD MONEY', 'GOTHIC / DARK'];
    $storedStyles = array_filter(array_map('trim', explode(',', $universe->style ?? '')));
    $selectedStyles = old('style', array_values(array_intersect($storedStyles, $styles)));
    $customStyleDefault = old('custom_style', implode(', ', array_diff($storedStyles, $styles)) ?: null);
@endphp

<x-app-layout>
    <x-slot name="header">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-1">{{ __('003 — Universe') }}</p>
        <h2 class="font-bold tracking-tight text-2xl text-ink leading-tight">
            {{ __('Edit your universe') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl bg-paper shadow-neu-card p-6">
                <form method="post" action="{{ route('universe.update') }}" class="flex flex-col gap-7">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col gap-2">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" :value="old('name', $universe->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="3" class="w-full bg-paper border-0 text-ink placeholder:text-ink/25 shadow-neu-inset focus:ring-0 focus:shadow-neu-inset rounded-xl px-4 py-3 text-sm">{{ old('description', $universe->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>

                    <div class="flex flex-col gap-3">
                        <x-input-label :value="__('Style / vibe')" />
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach ($styles as $style)
                                <label>
                                    <input type="checkbox" name="style[]" value="{{ $style }}" class="peer sr-only" @checked(in_array($style, $selectedStyles, true))>
                                    <span class="flex items-center justify-center rounded-full px-5 py-2.5 font-mono text-[10px] font-semibold tracking-[0.1em] text-muted shadow-neu-raised peer-checked:text-ink peer-checked:shadow-neu-inset active:shadow-neu-inset active:scale-[0.98] cursor-pointer transition-all">
                                        {{ $style }}
                                    </span>
                                </label>
                            @endforeach
                            <input type="text" name="custom_style" value="{{ $customStyleDefault }}" maxlength="100" placeholder="{{ __('Your own...') }}" class="w-36 rounded-full px-5 py-2.5 bg-paper border-0 font-mono text-[10px] font-semibold tracking-[0.1em] text-ink placeholder:text-muted shadow-neu-raised focus:shadow-neu-inset focus:ring-0" />
                        </div>
                        <p class="font-mono text-[9px] text-muted/70 mt-1">{{ __('Select as many as you like. Type your own to add an extra one.') }}</p>
                        <x-input-error :messages="$errors->get('style')" />
                        <x-input-error :messages="$errors->get('custom_style')" />
                    </div>

                    <div class="flex items-center gap-3 mt-2">
                        <x-primary-button>{{ __('Save changes') }}</x-primary-button>
                        <x-secondary-button type="button" onclick="window.location='{{ route('dashboard') }}'">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
