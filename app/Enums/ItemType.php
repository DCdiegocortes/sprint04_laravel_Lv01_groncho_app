<?php

namespace App\Enums;

enum ItemType: string
{
    case CLOTHES = 'CLOTHES';
    case ACCESSORIES = 'ACCESSORIES';

    public function label(): string
    {
        return match ($this) {
            self::CLOTHES => 'Clothes',
            self::ACCESSORIES => 'Accessories',
        };
    }
}
