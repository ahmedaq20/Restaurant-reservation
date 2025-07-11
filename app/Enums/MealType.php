<?php 

namespace App\Enums;

enum MealType:string 
{
    case BREAKFAST = 'breakfast';
    case LUNCH = 'Lunch';
    case DINNER = 'dinner';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}