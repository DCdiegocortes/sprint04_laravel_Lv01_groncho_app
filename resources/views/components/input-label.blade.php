@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-mono uppercase tracking-[0.18em] text-[10px] text-muted']) }}>
    {{ $value ?? $slot }}
</label>
