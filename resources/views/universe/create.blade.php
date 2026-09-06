@php
    $styles = ['MINIMAL / ZEN', 'Y2K / POP', 'DARK ACADEMIA / VINTAGE', 'PARISIAN / ECLECTIC', 'STREETWEAR', 'ROMANTIC / FLORAL', 'AVANT-GARDE', 'BOHO / EARTH', 'PREPPY / OLD MONEY', 'GOTHIC / DARK'];
    $selectedStyle = old('style');
@endphp

<x-app-layout>
    <x-slot name="header">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-1">{{ __('002 — Universe') }}</p>
        <h2 class="font-bold tracking-tight text-2xl text-ink leading-tight">
            {{ __('Create your universe') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl bg-paper shadow-neu-card p-6">
                <p class="text-sm text-muted mb-6">
                    {{ __('Your universe is your aesthetic profile: a name, a description and a vibe that represents you.') }}
                </p>

                <form method="post" action="{{ route('universe.store') }}" class="flex flex-col gap-7">
                    @csrf

                    <div class="flex flex-col gap-2">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" :value="old('name')" required autofocus placeholder="{{ __('Mermaidcore Dreamland') }}" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="3" class="w-full bg-paper border-0 text-ink placeholder:text-ink/25 shadow-neu-inset focus:ring-0 focus:shadow-neu-inset rounded-xl px-4 py-3 text-sm" placeholder="{{ __('Textures, colors, the vibe that represents you...') }}">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>

                    <div class="flex flex-col gap-3">
                        <x-input-label :value="__('Style / vibe')" />
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach ($styles as $style)
                                <label>
                                    <input type="radio" name="style" value="{{ $style }}" class="peer sr-only" @checked($selectedStyle === $style)>
                                    <span class="flex items-center justify-center rounded-full px-5 py-2.5 font-mono text-[10px] font-semibold tracking-[0.1em] text-muted shadow-neu-raised peer-checked:text-ink peer-checked:shadow-neu-inset active:shadow-neu-inset active:scale-[0.98] cursor-pointer transition-all">
                                        {{ $style }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('style')" />
                    </div>

                    <x-primary-button class="w-full mt-2">{{ __('Create universe') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
