<?php

namespace App\Services;

use App\Enums\ExchangeStatus;
use App\Enums\ExchangeType;
use App\Enums\ItemStatus;
use App\Models\Exchange;
use App\Models\Item;
use App\Models\MatchModel;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class ExchangeService
{
    public function create(User $requester, Item $requestedItem, string $type, ?Item $offeredItem, ?string $message): Exchange
    {
        if ($requestedItem->user_id === $requester->id) {
            throw ValidationException::withMessages([
                'requested_item_id' => __('You can\'t request your own item.'),
            ]);
        }

        $match = MatchModel::between($requester->id, $requestedItem->user_id);

        if (! $match) {
            throw ValidationException::withMessages([
                'requested_item_id' => __('You need to match with this user before requesting an item.'),
            ]);
        }

        if ($requestedItem->status !== ItemStatus::AVAILABLE) {
            throw ValidationException::withMessages([
                'requested_item_id' => __('This item is no longer available.'),
            ]);
        }

        if ($type === ExchangeType::GIFT->value) {
            if ($offeredItem) {
                throw ValidationException::withMessages([
                    'offered_item_id' => __('Gift requests can\'t include an offered item.'),
                ]);
            }
        } else {
            if (! $offeredItem) {
                throw ValidationException::withMessages([
                    'offered_item_id' => __('Choose one of your items to offer in trade.'),
                ]);
            }

            if ($offeredItem->user_id !== $requester->id) {
                throw ValidationException::withMessages([
                    'offered_item_id' => __('You can only offer your own items.'),
                ]);
            }

            if ($offeredItem->status !== ItemStatus::AVAILABLE) {
                throw ValidationException::withMessages([
                    'offered_item_id' => __('This item is no longer available.'),
                ]);
            }
        }

        return Exchange::create([
            'match_id' => $match->id,
            'requester_id' => $requester->id,
            'requested_item_id' => $requestedItem->id,
            'offered_item_id' => $offeredItem?->id,
            'type' => $type,
            'status' => ExchangeStatus::PENDING,
            'message' => $message,
        ]);
    }

    public function accept(Exchange $exchange, User $actingUser): Exchange
    {
        $this->authorizeItemOwner($exchange, $actingUser);

        if ($exchange->status !== ExchangeStatus::PENDING) {
            throw ValidationException::withMessages([
                'status' => __('This request is no longer pending.'),
            ]);
        }

        $exchange->requestedItem->update(['status' => ItemStatus::RESERVED]);
        $exchange->offeredItem?->update(['status' => ItemStatus::RESERVED]);

        $exchange->update(['status' => ExchangeStatus::ACCEPTED]);

        return $exchange;
    }

    public function reject(Exchange $exchange, User $actingUser): Exchange
    {
        $this->authorizeItemOwner($exchange, $actingUser);

        if ($exchange->status !== ExchangeStatus::PENDING) {
            throw ValidationException::withMessages([
                'status' => __('This request is no longer pending.'),
            ]);
        }

        $exchange->update(['status' => ExchangeStatus::REJECTED]);

        return $exchange;
    }

    public function finish(Exchange $exchange, User $actingUser): Exchange
    {
        $isParticipant = $actingUser->id === $exchange->requester_id
            || $actingUser->id === $exchange->requestedItem->user_id;

        abort_unless($isParticipant, 403);

        if ($exchange->status !== ExchangeStatus::ACCEPTED) {
            throw ValidationException::withMessages([
                'status' => __('This request needs to be accepted before it can be finished.'),
            ]);
        }

        $exchange->requestedItem->update([
            'status' => $exchange->type === ExchangeType::GIFT ? ItemStatus::GIFTED : ItemStatus::EXCHANGED,
        ]);
        $exchange->offeredItem?->update(['status' => ItemStatus::EXCHANGED]);

        $exchange->update(['status' => ExchangeStatus::FINISHED]);

        return $exchange;
    }

    public function cancel(Exchange $exchange, User $actingUser): void
    {
        abort_unless($exchange->requester_id === $actingUser->id, 403);

        if ($exchange->status !== ExchangeStatus::PENDING) {
            throw ValidationException::withMessages([
                'status' => __('Only pending requests can be cancelled.'),
            ]);
        }

        $exchange->delete();
    }

    private function authorizeItemOwner(Exchange $exchange, User $actingUser): void
    {
        abort_unless($exchange->requestedItem->user_id === $actingUser->id, 403);
    }
}
