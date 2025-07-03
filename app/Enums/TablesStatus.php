<?php

namespace App\Enums;

enum TablesStatus: string
{
    case AVAILABLE = 'available';
    case RESERVED = 'reserved';
    case OCCUPIED = 'occupied';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}