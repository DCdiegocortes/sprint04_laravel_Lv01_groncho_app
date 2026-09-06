<x-guest-layout>
    <div class="flex-none pt-20 pb-8 px-8">
        <p class="text-[26px] font-black leading-none mb-1 text-[#C8C8C6]" style="font-family: Inter, sans-serif; letter-spacing: 0.28em; text-shadow: -1px -1px 2px rgba(0,0,0,0.18), 2px 2px 3px rgba(255,255,255,0.95);">
            GRÔNCHÔ
        </p>
        <div class="h-[2px] mb-8 bg-accent" style="width: 66px;"></div>

        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted">{{ __('002 — Register') }}</p>
        <h1 class="text-[32px] font-bold tracking-[-0.03em] leading-[1.05] mt-2 text-ink">
            {{ __('Create your') }}<br>{{ __('universe.') }}
        </h1>
    </div>

    <div class="flex-1 px-8 pb-8">
        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-6">
            @csrf

            <div class="flex flex-col gap-2">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="{{ __('Your name') }}" />
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div class="flex flex-col gap-2">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@email.com" />
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

            <div class="flex flex-col gap-3 pt-2">
                <x-primary-button class="w-full">{{ __('Create account') }}</x-primary-button>

                <x-secondary-button type="button" class="w-full" onclick="window.location='{{ route('login') }}'">
                    {{ __('I already have an account') }}
                </x-secondary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
