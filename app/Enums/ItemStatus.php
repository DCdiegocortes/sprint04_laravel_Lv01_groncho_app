<?php

namespace App\Enums;

enum ItemStatus: string
{
    case AVAILABLE = 'AVAILABLE';
    case RESERVED = 'RESERVED';
    case EXCHANGED = 'EXCHANGED';
    case GIFTED = 'GIFTED';

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Available',
            self::RESERVED => 'Reserved',
            self::EXCHANGED => 'Exchanged',
            self::GIFTED => 'Gifted',
        };
    }
}
