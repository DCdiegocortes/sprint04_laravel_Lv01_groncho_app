@php
    $conditions = ['NEW' => 'New', 'EXCELLENT' => 'Excellent', 'GOOD' => 'Good', 'FAIR' => 'Fair'];
    $types = ['CLOTHES' => 'Clothes', 'ACCESSORIES' => 'Accessories'];
    $offerTypes = ['TRADE' => 'Trade', 'GIFT' => 'Gift', 'BOTH' => 'Trade or gift'];
@endphp

<x-app-layout>
    <x-slot name="header">
        <p class="font-mono uppercase tracking-[0.18em] text-[10px] text-muted mb-1">{{ __('006 — Wardrobe') }}</p>
        <h2 class="font-bold tracking-tight text-2xl text-ink leading-tight">
            {{ __('Edit item') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('items.index') }}" class="font-mono text-[10px] uppercase tracking-[0.12em] text-muted hover:text-accent">
                    {{ __('< Wardrobe') }}
                </a>
                <a href="{{ route('dashboard') }}" class="font-mono text-[10px] uppercase tracking-[0.12em] text-muted hover:text-accent">
                    {{ __('< Universe') }}
                </a>
            </div>

            @php
                $statusMessages = [
                    'item-updated' => __('Item updated.'),
                    'image-deleted' => __('Photo deleted.'),
                ];
            @endphp
            @if (session('status') && isset($statusMessages[session('status')]))
                <p class="font-mono text-[10px] text-accent mb-4">{{ $statusMessages[session('status')] }}</p>
            @endif

            <div class="rounded-2xl bg-paper shadow-neu-card p-6">
                <form method="post" action="{{ route('items.update', $item) }}" enctype="multipart/form-data" class="flex flex-col gap-7">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col gap-2">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" :value="old('title', $item->title)" required autofocus />
                        <x-input-error :messages="$errors->get('title')" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="3" class="w-full bg-paper border-0 text-ink placeholder:text-ink/25 shadow-neu-inset focus:ring-0 focus:shadow-neu-inset rounded-xl px-4 py-3 text-sm">{{ old('description', $item->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-input-label for="size" :value="__('Size')" />
                        <x-text-input id="size" name="size" type="text" :value="old('size', $item->size)" />
                        <x-input-error :messages="$errors->get('size')" />
                    </div>

                    <div class="flex flex-col gap-3">
                        <x-input-label :value="__('Category')" />
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach ($types as $value => $label)
                                <label>
                                    <input type="radio" name="type" value="{{ $value }}" class="peer sr-only" @checked(old('type', $item->type) === $value)>
                                    <span class="flex items-center justify-center rounded-full px-5 py-2.5 font-mono text-[10px] font-semibold tracking-[0.1em] text-muted shadow-neu-raised peer-checked:text-ink peer-checked:shadow-neu-inset active:shadow-neu-inset active:scale-[0.98] cursor-pointer transition-all">
                                        {{ strtoupper($label) }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('type')" />
                    </div>

                    <div class="flex flex-col gap-3">
                        <x-input-label :value="__('Condition')" />
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach ($conditions as $value => $label)
                                <label>
                                    <input type="radio" name="item_condition" value="{{ $value }}" class="peer sr-only" @checked(old('item_condition', $item->item_condition) === $value)>
                                    <span class="flex items-center justify-center rounded-full px-5 py-2.5 font-mono text-[10px] font-semibold tracking-[0.1em] text-muted shadow-neu-raised peer-checked:text-ink peer-checked:shadow-neu-inset active:shadow-neu-inset active:scale-[0.98] cursor-pointer transition-all">
                                        {{ strtoupper($label) }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('item_condition')" />
                    </div>

                    <div class="flex flex-col gap-3">
                        <x-input-label :value="__('Offer type')" />
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach ($offerTypes as $value => $label)
                                <label>
                                    <input type="radio" name="offer_type" value="{{ $value }}" class="peer sr-only" @checked(old('offer_type', $item->offer_type) === $value)>
                                    <span class="flex items-center justify-center rounded-full px-5 py-2.5 font-mono text-[10px] font-semibold tracking-[0.1em] text-muted shadow-neu-raised peer-checked:text-ink peer-checked:shadow-neu-inset active:shadow-neu-inset active:scale-[0.98] cursor-pointer transition-all">
                                        {{ strtoupper($label) }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('offer_type')" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-input-label :value="__('Photos')" />

                        @if ($item->images->isNotEmpty())
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                @foreach ($item->images as $image)
                                    <div class="relative">
                                        <img src="{{ asset('storage/'.$image->path) }}" alt="" class="w-full rounded-2xl shadow-neu-card">
                                        <button type="submit" form="delete-image-{{ $image->id }}" class="absolute top-2 right-2 flex items-center justify-center w-6 h-6 text-white hover:text-accent active:scale-90 transition ease-in-out duration-150" style="filter: drop-shadow(0 1px 2px rgba(0,0,0,0.5));">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="rounded-2xl p-3 bg-paper shadow-neu-inset flex flex-col items-center gap-1.5 text-center">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center bg-paper shadow-neu-subtle">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 17a4 4 0 100-8 4 4 0 000 8z" />
                                </svg>
                            </div>
                            <p class="font-mono text-[9px] text-muted/70">{{ __('JPG, PNG · up to 10MB each') }}</p>
                            <input id="images" name="images[]" type="file" accept="image/png,image/jpeg" multiple class="sr-only peer" />
                            <label for="images" class="inline-flex items-center justify-center py-1.5 px-3 bg-paper rounded-full font-semibold text-[11px] text-ink tracking-[0.05em] shadow-neu-raised cursor-pointer active:shadow-neu-inset active:scale-[0.98] transition ease-in-out duration-150">
                                {{ __('Add more photos') }}
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('images')" />
                        <x-input-error :messages="$errors->get('images.0')" />
                    </div>

                    <div class="flex items-center gap-3 mt-2">
                        <x-primary-button class="!py-2.5 !px-5 !text-xs">{{ __('Save changes') }}</x-primary-button>
                        <x-secondary-button type="button" class="!py-2.5 !px-5 !text-xs" onclick="window.location='{{ route('items.index') }}'">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                    </div>
                </form>

                @foreach ($item->images as $image)
                    <form id="delete-image-{{ $image->id }}" method="post" action="{{ route('items.images.destroy', [$item, $image]) }}" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach

                <form method="post" action="{{ route('items.destroy', $item) }}" class="mt-4" onsubmit="return confirm('{{ __('Delete this item? This cannot be undone.') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="font-mono text-[10px] uppercase tracking-[0.12em] text-muted hover:text-accent">
                        {{ __('Delete item') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
