<?php

namespace App\Enums;

enum ItemCondition: string
{
    case NEW = 'NEW';
    case EXCELLENT = 'EXCELLENT';
    case GOOD = 'GOOD';
    case FAIR = 'FAIR';

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'New',
            self::EXCELLENT => 'Excellent',
            self::GOOD => 'Good',
            self::FAIR => 'Fair',
        };
    }
}
