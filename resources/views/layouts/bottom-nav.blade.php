@php
    $tabs = [
        ['route' => route('discover'), 'active' => request()->routeIs('discover'), 'label' => __('Discover')],
        ['route' => route('items.index'), 'active' => request()->routeIs('items.*'), 'label' => __('Closet')],
        ['route' => route('matches.index'), 'active' => request()->routeIs('matches.*'), 'label' => __('Matches')],
        ['route' => route('dashboard'), 'active' => request()->routeIs('dashboard'), 'label' => __('Universe')],
    ];
@endphp

<nav class="fixed bottom-0 left-0 right-0 bg-paper border-t border-ink/7 z-30">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-around py-3">
        <a href="{{ $tabs[0]['route'] }}" class="flex flex-col items-center gap-1">
            <span class="w-14 h-9 rounded-full flex items-center justify-center {{ $tabs[0]['active'] ? 'bg-paper shadow-neu-inset text-ink' : 'text-muted' }}">
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none">
                    <path d="M2 14C6 6.5 18 6.5 22 14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                    <circle cx="12" cy="12" r="3.2" fill="currentColor" />
                </svg>
            </span>
            <span class="font-mono uppercase tracking-[0.1em] text-[8px] {{ $tabs[0]['active'] ? 'text-ink font-semibold' : 'text-muted' }}">{{ $tabs[0]['label'] }}</span>
            <span class="w-3 h-0.5 rounded-full {{ $tabs[0]['active'] ? 'bg-accent' : 'bg-transparent' }}"></span>
        </a>

        <a href="{{ $tabs[1]['route'] }}" class="flex flex-col items-center gap-1">
            <span class="w-14 h-9 rounded-full flex items-center justify-center {{ $tabs[1]['active'] ? 'bg-paper shadow-neu-inset text-ink' : 'text-muted' }}">
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="1.5" />
                    <line x1="3" y1="9" x2="21" y2="9" />
                    <line x1="3" y1="15" x2="21" y2="15" />
                    <line x1="10.5" y1="6" x2="13.5" y2="6" />
                    <line x1="10.5" y1="12" x2="13.5" y2="12" />
                    <line x1="10.5" y1="18" x2="13.5" y2="18" />
                </svg>
            </span>
            <span class="font-mono uppercase tracking-[0.1em] text-[8px] {{ $tabs[1]['active'] ? 'text-ink font-semibold' : 'text-muted' }}">{{ $tabs[1]['label'] }}</span>
            <span class="w-3 h-0.5 rounded-full {{ $tabs[1]['active'] ? 'bg-accent' : 'bg-transparent' }}"></span>
        </a>

        <a href="{{ $tabs[2]['route'] }}" class="flex flex-col items-center gap-1">
            <span class="w-14 h-9 rounded-full flex items-center justify-center {{ $tabs[2]['active'] ? 'bg-paper shadow-neu-inset text-ink' : 'text-muted' }}">
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                </svg>
            </span>
            <span class="font-mono uppercase tracking-[0.1em] text-[8px] {{ $tabs[2]['active'] ? 'text-ink font-semibold' : 'text-muted' }}">{{ $tabs[2]['label'] }}</span>
            <span class="w-3 h-0.5 rounded-full {{ $tabs[2]['active'] ? 'bg-accent' : 'bg-transparent' }}"></span>
        </a>

        <a href="{{ $tabs[3]['route'] }}" class="flex flex-col items-center gap-1">
            <span class="w-14 h-9 rounded-full flex items-center justify-center {{ $tabs[3]['active'] ? 'bg-paper shadow-neu-inset text-ink' : 'text-muted' }}">
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3 L13.5 10.5 L21 12 L13.5 13.5 L12 21 L10.5 13.5 L3 12 L10.5 10.5 Z" />
                    <line x1="19" y1="4" x2="19" y2="8" />
                    <line x1="17" y1="6" x2="21" y2="6" />
                </svg>
            </span>
            <span class="font-mono uppercase tracking-[0.1em] text-[8px] {{ $tabs[3]['active'] ? 'text-ink font-semibold' : 'text-muted' }}">{{ $tabs[3]['label'] }}</span>
            <span class="w-3 h-0.5 rounded-full {{ $tabs[3]['active'] ? 'bg-accent' : 'bg-transparent' }}"></span>
        </a>
    </div>
</nav>
