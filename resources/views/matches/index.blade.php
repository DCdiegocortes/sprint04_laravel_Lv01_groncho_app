<x-app-layout>
    <x-slot name="header">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-1">{{ __('008 — Matches') }}</p>
        <h2 class="font-bold tracking-tight text-2xl text-ink leading-tight">
            {{ __('Matches') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($matches->isEmpty())
                <div class="rounded-2xl bg-paper shadow-neu-card p-6 flex items-center justify-between">
                    <p class="text-sm text-muted">{{ __("No matches yet.") }}</p>
                    <a href="{{ route('discover') }}" class="inline-flex items-center py-2.5 px-5 bg-accent rounded-full font-semibold text-xs text-white tracking-[0.05em] shadow-neu-accent">
                        {{ __('Keep swiping') }}
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach ($matches as $match)
                        @php $other = $match->other(auth()->id()); $images = $other->universe?->images; @endphp
                        <a href="{{ route('universe.show', $other) }}" class="block rounded-2xl overflow-hidden bg-paper shadow-neu-card active:shadow-neu-inset transition ease-in-out duration-150">
                            <div class="px-4 pt-4 pb-3">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3 bg-paper shadow-neu-subtle">
                                    <span class="font-mono text-base text-ink">{{ strtoupper(substr($other->name, 0, 1)) }}</span>
                                </div>
                                <p class="text-sm font-semibold leading-tight text-ink mb-1">{{ $other->name }}</p>
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
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
