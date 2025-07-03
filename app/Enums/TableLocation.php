<?php

namespace App\Enums;

enum TableLocation: string
{
    case INDOOR = 'Indoor';
    case OUTDOOR = 'Outdoor';
    case BALCONY = 'Balcony';
    case ROOFTOP = 'Rooftop';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}