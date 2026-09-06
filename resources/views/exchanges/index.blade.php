@php
    $statusColors = [
        'PENDING' => 'text-muted',
        'ACCEPTED' => 'text-ink',
        'REJECTED' => 'text-muted',
        'FINISHED' => 'text-accent',
    ];
    $statusMessages = [
        'exchange-requested' => __('Request sent.'),
        'exchange-accepted' => __('Request accepted.'),
        'exchange-rejected' => __('Request rejected.'),
        'exchange-finished' => __('Exchange finished.'),
        'exchange-cancelled' => __('Request cancelled.'),
    ];
    $exchanges = $tab === 'sent' ? $sent : $received;
@endphp

<x-app-layout>
    <x-slot name="header">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-1">{{ __('009 — Exchange') }}</p>
        <h2 class="font-bold tracking-tight text-2xl text-ink leading-tight">
            {{ __('Requests') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('status') && isset($statusMessages[session('status')]))
                <p class="font-mono text-[10px] text-accent mb-4">{{ $statusMessages[session('status')] }}</p>
            @endif

            <div class="flex w-full rounded-full shadow-neu-raised p-1 mb-4">
                <a href="{{ route('exchanges.index', ['tab' => 'received', 'status' => $status]) }}" class="flex-1 text-center px-5 py-2.5 rounded-full font-mono text-[10px] font-semibold tracking-[0.1em] transition ease-in-out duration-150 {{ $tab === 'received' ? 'bg-paper shadow-neu-inset text-ink' : 'text-muted' }}">
                    {{ __('RECEIVED') }} ({{ $received->count() }})
                </a>
                <a href="{{ route('exchanges.index', ['tab' => 'sent', 'status' => $status]) }}" class="flex-1 text-center px-5 py-2.5 rounded-full font-mono text-[10px] font-semibold tracking-[0.1em] transition ease-in-out duration-150 {{ $tab === 'sent' ? 'bg-paper shadow-neu-inset text-ink' : 'text-muted' }}">
                    {{ __('SENT') }} ({{ $sent->count() }})
                </a>
            </div>

            <div class="flex w-full gap-2 mb-6">
                @foreach (['ALL' => __('All'), 'PENDING' => __('Pending'), 'ACCEPTED' => __('Accepted'), 'FINISHED' => __('Finished'), 'REJECTED' => __('Rejected')] as $value => $label)
                    <a href="{{ route('exchanges.index', ['tab' => $tab, 'status' => $value]) }}" class="flex-1 text-center px-4 py-1.5 rounded-full font-mono uppercase text-[9px] font-semibold tracking-[0.1em] transition ease-in-out duration-150 {{ $status === $value ? 'bg-paper shadow-neu-inset text-ink' : 'shadow-neu-raised text-muted' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            @if ($exchanges->isEmpty())
                <div class="rounded-2xl bg-paper shadow-neu-card p-6 text-center">
                    <p class="text-sm text-muted">{{ __("Nothing here yet.") }}</p>
                </div>
            @else
                <div class="flex flex-col gap-3">
                    @foreach ($exchanges as $exchange)
                        @php
                            $otherName = $tab === 'sent' ? $exchange->requestedItem->user->name : $exchange->requester->name;
                        @endphp
                        <div class="rounded-2xl bg-paper shadow-neu-card px-5 pt-5 pb-3">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-paper shadow-neu-subtle shrink-0">
                                        <span class="font-mono text-lg text-ink">{{ strtoupper(substr($otherName, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-xl font-semibold leading-tight text-ink">{{ $otherName }}</p>
                                        <p class="font-mono uppercase tracking-[0.1em] text-[9px] text-accent">
                                            {{ $tab === 'sent' ? __('Request sent') : __('Wants to :type', ['type' => $exchange->type === \App\Enums\ExchangeType::GIFT ? __('give a gift') : __('trade')]) }}
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
                                    <span class="font-mono uppercase tracking-[0.1em] text-[8px] text-muted">{{ $tab === 'sent' ? __('You requested') : __('Requested') }}</span>
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
                                        <span class="font-mono uppercase tracking-[0.1em] text-[8px] text-muted">{{ $tab === 'sent' ? __('You offered') : __('Offered') }}</span>
                                    </div>
                                @endif
                            </div>

                            @if ($exchange->message)
                                <div class="rounded-xl bg-paper shadow-neu-inset px-6 py-5 mt-6 mb-4">
                                    <p class="text-sm text-ink leading-relaxed">&quot;{{ $exchange->message }}&quot;</p>
                                </div>
                            @endif

                            @if ($tab === 'received' && $exchange->status === \App\Enums\ExchangeStatus::PENDING)
                                <div class="flex items-center gap-3">
                                    <form method="post" action="{{ route('exchanges.update', $exchange) }}" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="ACCEPTED">
                                        <x-primary-button class="w-full !py-2.5 !px-4 !text-xs">{{ __('Accept') }}</x-primary-button>
                                    </form>
                                    <form method="post" action="{{ route('exchanges.update', $exchange) }}" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="REJECTED">
                                        <x-secondary-button type="submit" class="w-full !py-2.5 !px-4 !text-xs">{{ __('Reject') }}</x-secondary-button>
                                    </form>
                                </div>
                            @elseif ($tab === 'sent' && $exchange->status === \App\Enums\ExchangeStatus::PENDING)
                                <form method="post" action="{{ route('exchanges.destroy', $exchange) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-secondary-button type="submit" class="w-full !py-2.5 !px-4 !text-xs">{{ __('Cancel request') }}</x-secondary-button>
                                </form>
                            @elseif ($exchange->status === \App\Enums\ExchangeStatus::ACCEPTED)
                                <form method="post" action="{{ route('exchanges.update', $exchange) }}" class="flex justify-center mt-6">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="FINISHED">
                                    <x-primary-button class="w-full max-w-xs !py-2.5 !px-4 !text-xs">{{ __('Mark as finished') }}</x-primary-button>
                                </form>
                            @endif

                            <p class="font-mono uppercase tracking-[0.1em] text-[11px] text-right text-muted mt-3" style="text-shadow: -0.5px -0.5px 1px rgba(0,0,0,0.15), 1px 1px 1.5px rgba(255,255,255,0.9);">
                                {{ $exchange->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
