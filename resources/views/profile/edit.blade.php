<x-app-layout>
    <x-slot name="header">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-1">{{ __('010 — Profile') }}</p>
        <h2 class="font-bold tracking-tight text-2xl text-ink leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-6">
            <div class="rounded-2xl bg-paper shadow-neu-card p-6">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="rounded-2xl bg-paper shadow-neu-card p-6">
                @include('profile.partials.update-password-form')
            </div>

            <div class="rounded-2xl bg-paper shadow-neu-card p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
