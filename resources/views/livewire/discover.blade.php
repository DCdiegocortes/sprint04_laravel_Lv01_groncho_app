<div>
    @if ($justMatched)
        <div class="rounded-2xl bg-paper shadow-neu-card p-4 mb-4 text-center">
            <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-accent">{{ __("It's a match with :name", ['name' => $justMatched]) }}</p>
        </div>
    @endif

    @if ($candidate && $candidate->universe)
        @php $universe = $candidate->universe; @endphp
        <div class="rounded-2xl overflow-hidden bg-paper shadow-neu-card">
            <div class="relative h-40" style="background: linear-gradient(135deg, #C8C8C6, #E6E6E4);"></div>

            <div class="px-6 -mt-8 relative pb-6">
                <div class="w-16 h-16 rounded-xl flex items-center justify-center mb-4 bg-paper shadow-neu-subtle" style="border: 4px solid #E6E6E4;">
                    <span class="font-mono text-lg text-ink">{{ strtoupper(substr($candidate->name, 0, 1)) }}</span>
                </div>

                <p class="font-mono text-[10px] text-muted mb-1">{{ $candidate->name }}</p>

                @if ($universe->style)
                    <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted">{{ $universe->style }}</p>
                @endif
                <h3 class="text-2xl font-bold tracking-[-0.02em] leading-tight mt-2 mb-2 text-ink">{{ $universe->name }}</h3>

                @if ($universe->description)
                    <p class="text-sm leading-relaxed mb-6 text-muted">{{ $universe->description }}</p>
                @endif

                @if ($universe->images->isNotEmpty())
                    <div class="columns-2 sm:columns-3 gap-3 mb-6 [&>*]:mb-3 [&>*]:break-inside-avoid">
                        @foreach ($universe->images as $image)
                            <img src="{{ asset('storage/'.$image->path) }}" alt="" class="w-full rounded-2xl shadow-neu-card">
                        @endforeach
                    </div>
                @endif

                <div class="flex items-center justify-center gap-8">
                    <div class="flex flex-col items-center gap-2">
                        <button type="button" wire:click="nope" class="w-16 h-16 inline-flex items-center justify-center rounded-full bg-paper shadow-neu-raised active:shadow-neu-inset active:scale-95 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <span class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted">{{ __('Nope') }}</span>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <button type="button" wire:click="like" class="w-16 h-16 inline-flex items-center justify-center rounded-full bg-paper shadow-neu-raised active:shadow-neu-inset active:scale-95 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-accent" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                            </svg>
                        </button>
                        <span class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted">{{ __('Like') }}</span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="rounded-2xl bg-paper shadow-neu-card p-10 text-center">
            <p class="text-lg font-bold tracking-[-0.02em] text-ink mb-2">{{ __("You've seen everyone") }}</p>
            <p class="font-mono uppercase tracking-[0.14em] text-[10px] text-muted">{{ __('Check back later for new universes') }}</p>
        </div>
    @endif
</div>
