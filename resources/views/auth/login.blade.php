<x-guest-layout>
    <div class="flex-none pt-24 pb-8 px-8">
        <p class="text-[28px] font-black leading-none mb-1 text-[#C8C8C6]" style="font-family: Inter, sans-serif; letter-spacing: 0.28em; text-shadow: -1px -1px 2px rgba(0,0,0,0.18), 2px 2px 3px rgba(255,255,255,0.95);">
            GRÔNCHÔ
        </p>
        <div class="h-[2px] mb-10 bg-accent" style="width: 66px;"></div>

        <x-auth-session-status class="mb-4 font-mono text-[10px] text-muted" :status="session('status')" />

        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted">{{ __('001 — Access') }}</p>
        <h1 class="text-[34px] font-bold tracking-[-0.03em] leading-[1.05] mt-2 text-ink">
            {{ __("Let's loop through") }}<br>{{ __('the universes.') }}
        </h1>
    </div>

    <div class="flex-1 px-8 pb-8">
        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-7">
            @csrf

            <div class="flex flex-col gap-2">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@email.com" />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="flex flex-col gap-2">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="··········" />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <label for="remember_me" class="inline-flex items-center gap-2">
                <input id="remember_me" type="checkbox" class="rounded border-ink/15 text-accent shadow-none focus:ring-accent" name="remember">
                <span class="font-mono text-[10px] uppercase tracking-[0.12em] text-muted">{{ __('Remember me') }}</span>
            </label>

            <div class="flex flex-col gap-3 pt-2">
                <x-primary-button class="w-full">{{ __('Log in') }}</x-primary-button>

                @if (Route::has('register'))
                    <x-secondary-button type="button" class="w-full" onclick="window.location='{{ route('register') }}'">
                        {{ __('Create account') }}
                    </x-secondary-button>
                @endif
            </div>

            @if (Route::has('password.request'))
                <a class="text-center font-mono text-[10px] uppercase tracking-[0.12em] text-muted hover:text-ink" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </form>
    </div>

    <div class="flex-none h-24 relative overflow-hidden">
        <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=800&h=200&fit=crop&auto=format" alt="" class="w-full h-full object-cover">
    </div>
</x-guest-layout>
