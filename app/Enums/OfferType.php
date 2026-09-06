<?php

namespace App\Enums;

enum OfferType: string
{
    case TRADE = 'TRADE';
    case GIFT = 'GIFT';
    case BOTH = 'BOTH';

    public function label(): string
    {
        return match ($this) {
            self::TRADE => 'Trade',
            self::GIFT => 'Gift',
            self::BOTH => 'Trade or gift',
        };
    }
}
