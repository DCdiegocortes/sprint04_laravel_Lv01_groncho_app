<x-guest-layout>
    <div class="px-8 pt-10 pb-8">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-2">{{ __('New password') }}</p>
        <h1 class="text-2xl font-bold tracking-[-0.02em] text-ink mb-6">{{ __('Reset your password') }}</h1>

        <form method="POST" action="{{ route('password.store') }}" class="flex flex-col gap-6">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="flex flex-col gap-2">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="flex flex-col gap-2">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="··········" />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="flex flex-col gap-2">
                <x-input-label for="password_confirmation" :value="__('Confirm password')" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="··········" />
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <div class="flex justify-center mt-1">
                <x-primary-button class="!py-2.5 !px-5 !text-xs">
                    {{ __('Reset Password') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
