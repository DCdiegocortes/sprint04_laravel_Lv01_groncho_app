<x-guest-layout>
    <div class="px-8 pt-10 pb-8">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-2">{{ __('Confirm password') }}</p>
        <p class="text-sm leading-relaxed text-muted mb-6">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>

        <form method="POST" action="{{ route('password.confirm') }}" class="flex flex-col gap-6">
            @csrf

            <div class="flex flex-col gap-2">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="··········" />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="flex justify-center">
                <x-primary-button class="!py-2.5 !px-5 !text-xs">
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
