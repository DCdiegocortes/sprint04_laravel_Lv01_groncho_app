@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-paper border-0 text-ink placeholder:text-ink/25 shadow-neu-inset focus:ring-0 focus:shadow-neu-inset rounded-xl px-4 py-3 text-sm']) }}>
