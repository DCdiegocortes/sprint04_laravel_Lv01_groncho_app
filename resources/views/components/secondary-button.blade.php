<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center py-4 px-6 bg-paper border border-transparent rounded-full font-semibold text-sm text-ink tracking-[0.05em] shadow-neu-raised hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-paper disabled:opacity-25 active:shadow-neu-inset active:scale-[0.98] transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
