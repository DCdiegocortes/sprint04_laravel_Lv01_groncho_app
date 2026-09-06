@php
    $isRequester = auth()->id() === $exchange->requester_id;
    $otherName = $isRequester ? $exchange->requestedItem->user->name : $exchange->requester->name;
    $statusColors = [
        'PENDING' => 'text-muted',
        'ACCEPTED' => 'text-ink',
        'REJECTED' => 'text-muted',
        'FINISHED' => 'text-accent',
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-1">{{ __('009 — Exchange') }}</p>
        <h2 class="font-bold tracking-tight text-2xl text-ink leading-tight">
            {{ __('Request detail') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl bg-paper shadow-neu-card p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-paper shadow-neu-subtle shrink-0">
                            <span class="font-mono text-base text-ink">{{ strtoupper(substr($otherName, 0, 1)) }}</span>
                        </div>
                        <div>
                            <p class="text-base font-semibold leading-tight text-ink">{{ $otherName }}</p>
                            <p class="font-mono uppercase tracking-[0.1em] text-[9px] text-accent">
                                {{ $isRequester ? __('Request sent') : __('Wants to :type', ['type' => $exchange->type === \App\Enums\ExchangeType::GIFT ? __('give a gift') : __('trade')]) }}
                            </p>
                        </div>
                    </div>
                    <span class="font-mono uppercase tracking-[0.1em] text-[9px] px-3 py-1 rounded-full shadow-neu-subtle {{ $statusColors[$exchange->status->value] ?? 'text-muted' }}">
                        {{ $exchange->status->value }}
                    </span>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch justify-center gap-4 mb-4">
                    <div class="flex-1 flex flex-col items-center gap-2 rounded-xl bg-paper shadow-neu-subtle p-3">
                        @if ($exchange->requestedItem->images->isNotEmpty())
                            <img src="{{ asset('storage/'.$exchange->requestedItem->images->first()->path) }}" alt="" class="w-full aspect-square rounded-lg object-cover shadow-neu-card">
                        @else
                            <div class="w-full aspect-square rounded-lg shadow-neu-card" style="background-color: #D4D4D2;"></div>
                        @endif
                        <span class="font-mono uppercase tracking-[0.1em] text-[8px] text-muted">{{ $isRequester ? __('You requested') : __('Requested') }}</span>
                    </div>

                    @if ($exchange->offeredItem)
                        <div class="hidden sm:flex items-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8l-4 4m0 0l4 4m-4-4h18m-4-8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>

                        <div class="flex-1 flex flex-col items-center gap-2 rounded-xl bg-paper shadow-neu-subtle p-3">
                            @if ($exchange->offeredItem->images->isNotEmpty())
                                <img src="{{ asset('storage/'.$exchange->offeredItem->images->first()->path) }}" alt="" class="w-full aspect-square rounded-lg object-cover shadow-neu-card">
                            @else
                                <div class="w-full aspect-square rounded-lg shadow-neu-card" style="background-color: #D4D4D2;"></div>
                            @endif
                            <span class="font-mono uppercase tracking-[0.1em] text-[8px] text-muted">{{ $isRequester ? __('You offered') : __('Offered') }}</span>
                        </div>
                    @endif
                </div>

                @if ($exchange->message)
                    <div class="rounded-xl bg-paper shadow-neu-inset px-4 py-3">
                        <p class="text-sm text-ink leading-relaxed">&quot;{{ $exchange->message }}&quot;</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
