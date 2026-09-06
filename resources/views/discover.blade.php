<x-app-layout>
    <x-slot name="header">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-1">{{ __('007 — Discover') }}</p>
        <h2 class="font-bold tracking-tight text-2xl text-ink leading-tight">
            {{ __('Discover') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[28px] font-black leading-none mb-1 text-[#C8C8C6]" style="font-family: Inter, sans-serif; letter-spacing: 0.28em; text-shadow: -1px -1px 2px rgba(0,0,0,0.18), 2px 2px 3px rgba(255,255,255,0.95);">
                GRÔNCHÔ
            </p>
            <div class="h-[2px] mb-8 bg-accent" style="width: 66px;"></div>

            <livewire:discover />
        </div>
    </div>
</x-app-layout>
