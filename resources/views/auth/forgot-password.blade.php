<x-guest-layout>
    <div class="px-8 pt-10 pb-8">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-2">{{ __('Reset password') }}</p>
        <p class="text-sm leading-relaxed text-muted mb-6">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>

        <x-auth-session-status class="mb-4 font-mono text-[10px] text-muted" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf

            <div class="flex flex-col gap-2">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="you@email.com" />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="flex justify-center">
                <x-primary-button class="!py-2.5 !px-5 !text-xs">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
