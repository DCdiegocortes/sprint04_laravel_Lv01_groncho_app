@php
    $offerTypes = collect(['TRADE' => 'Trade', 'GIFT' => 'Gift'])
        ->only($item->offer_type === \App\Enums\OfferType::BOTH ? ['TRADE', 'GIFT'] : [$item->offer_type->value]);
@endphp

<x-app-layout>
    <x-slot name="header">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-1">{{ __('009 — Exchange') }}</p>
        <h2 class="font-bold tracking-tight text-2xl text-ink leading-tight">
            {{ __('Request item') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl bg-paper shadow-neu-card p-6 mb-6 flex items-center gap-4">
                @if ($item->images->isNotEmpty())
                    <img src="{{ asset('storage/'.$item->images->first()->path) }}" alt="" class="w-16 h-16 rounded-xl object-cover shadow-neu-subtle">
                @endif
                <div>
                    <p class="text-sm font-semibold leading-tight text-ink mb-1">{{ $item->title }}</p>
                    <p class="font-mono text-[10px] text-muted">{{ $item->size ?? '—' }}</p>
                </div>
            </div>

            <div class="rounded-2xl bg-paper shadow-neu-card p-6">
                <form method="post" action="{{ route('exchanges.store') }}" class="flex flex-col gap-7">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">

                    <div class="flex flex-col gap-3">
                        <x-input-label :value="__('Type')" />
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach ($offerTypes as $value => $label)
                                <label>
                                    <input type="radio" name="type" value="{{ $value }}" class="peer sr-only" @checked(old('type', $offerTypes->keys()->first()) === $value)>
                                    <span class="flex items-center justify-center rounded-full px-5 py-2.5 font-mono text-[10px] font-semibold tracking-[0.1em] text-muted shadow-neu-raised peer-checked:text-ink peer-checked:shadow-neu-inset active:shadow-neu-inset active:scale-[0.98] cursor-pointer transition-all">
                                        {{ strtoupper($label) }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('type')" />
                    </div>

                    @if ($offerTypes->has('TRADE'))
                        <div class="flex flex-col gap-2">
                            <x-input-label for="offered_item_id" :value="__('Offer one of your items (for trade)')" />
                            <select id="offered_item_id" name="offered_item_id" class="w-full bg-paper border-0 text-ink shadow-neu-inset focus:ring-0 focus:shadow-neu-inset rounded-xl px-4 py-3 text-sm">
                                <option value="">{{ __('— None (gift) —') }}</option>
                                @foreach ($myItems as $myItem)
                                    <option value="{{ $myItem->id }}" @selected(old('offered_item_id') == $myItem->id)>{{ $myItem->title }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('offered_item_id')" />
                        </div>
                    @endif

                    <div class="flex flex-col gap-2">
                        <x-input-label for="message" :value="__('Message (optional)')" />
                        <textarea id="message" name="message" rows="3" class="w-full bg-paper border-0 text-ink placeholder:text-ink/25 shadow-neu-inset focus:ring-0 focus:shadow-neu-inset rounded-xl px-4 py-3 text-sm" placeholder="{{ __('Say something about your request...') }}">{{ old('message') }}</textarea>
                        <x-input-error :messages="$errors->get('message')" />
                    </div>

                    <x-primary-button class="w-full mt-2">{{ __('Send request') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
