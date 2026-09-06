<?php

namespace App\Enums;

enum ExchangeType: string
{
    case TRADE = 'TRADE';
    case GIFT = 'GIFT';

    public function label(): string
    {
        return match ($this) {
            self::TRADE => 'Trade',
            self::GIFT => 'Gift',
        };
    }
}
