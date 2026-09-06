<x-guest-layout>
    <div class="px-8 pt-10 pb-8">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-2">{{ __('Verify email') }}</p>
        <p class="text-sm leading-relaxed text-muted mb-6">
            {{ __("Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.") }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <p class="font-mono text-[10px] text-accent mb-6">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </p>
        @endif

        <div class="flex flex-col items-center gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="!py-2.5 !px-5 !text-xs">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="font-mono text-[10px] uppercase tracking-[0.12em] text-muted hover:text-accent">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
