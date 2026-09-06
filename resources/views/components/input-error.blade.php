@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'font-mono text-[10px] text-accent space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>— {{ $message }}</li>
        @endforeach
    </ul>
@endif
