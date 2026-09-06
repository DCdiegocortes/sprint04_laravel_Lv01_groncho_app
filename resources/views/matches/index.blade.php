<x-app-layout>
    <x-slot name="header">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-1">{{ __('008 — Matches') }}</p>
        <h2 class="font-bold tracking-tight text-2xl text-ink leading-tight">
            {{ __('Matches') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[28px] font-black leading-none mb-1 text-[#C8C8C6]" style="font-family: Inter, sans-serif; letter-spacing: 0.28em; text-shadow: -1px -1px 2px rgba(0,0,0,0.18), 2px 2px 3px rgba(255,255,255,0.95);">
                GRÔNCHÔ
            </p>
            <div class="h-[2px] mb-8 bg-accent" style="width: 66px;"></div>

            @if ($matches->isEmpty())
                <div class="rounded-2xl bg-paper shadow-neu-card p-6 flex items-center justify-between">
                    <p class="text-sm text-muted">{{ __("No matches yet.") }}</p>
                    <a href="{{ route('discover') }}" class="inline-flex items-center py-2.5 px-5 bg-accent rounded-full font-semibold text-xs text-white tracking-[0.05em] shadow-neu-accent">
                        {{ __('Keep swiping') }}
                    </a>
                </div>
            @else
                <div class="flex flex-wrap gap-3">
                    @foreach ($matches as $match)
                        @php $other = $match->other(auth()->id()); $images = $other->universe?->images; @endphp
                        <a href="{{ route('universe.show', $other) }}" class="block w-full sm:w-64 rounded-2xl overflow-hidden bg-paper shadow-neu-card active:shadow-neu-inset transition ease-in-out duration-150">
                            <div class="px-4 pt-4 pb-3">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-paper shadow-neu-subtle shrink-0">
                                        <span class="font-mono text-base text-ink">{{ strtoupper(substr($other->name, 0, 1)) }}</span>
                                    </div>
                                    <p class="text-lg font-semibold leading-tight text-ink">{{ $other->name }}</p>
                                </div>
                                @if ($other->universe?->style)
                                    <p class="font-mono uppercase tracking-[0.14em] text-[9px] text-muted">{{ $other->universe->style }}</p>
                                @endif
                            </div>

                            @if ($images && $images->isNotEmpty())
                                @foreach ($images->take(3) as $image)
                                    <img src="{{ asset('storage/'.$image->path) }}" alt="" class="w-full block">
                                @endforeach
                            @else
                                <div class="h-20" style="background: linear-gradient(135deg, #C8C8C6, #E6E6E4);"></div>
                            @endif
                        </a>
                    @endforeach

                    @for ($i = 0; $i < max(0, 3 - $matches->count()); $i++)
                        <div class="w-full sm:w-64 rounded-2xl bg-paper shadow-neu-inset flex flex-col items-center justify-center gap-3 p-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                            </svg>
                            <p class="font-mono uppercase tracking-[0.14em] text-[9px] text-muted">{{ __('Matching...') }}</p>
                        </div>
                    @endfor
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
