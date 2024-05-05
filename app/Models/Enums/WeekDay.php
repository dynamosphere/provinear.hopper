<?php

namespace App\Models\Enums;

enum WeekDay: string
{
    case SUNDAY = 'SUNDAY';
    case MONDAY = 'MONDAY';
    case TUESDAY = 'TUESDAY';
    case WEDNESDAY = 'WEDNESDAY';
    case THURSDAY = 'THURSDAY';
    case FRIDAY = 'FRIDAY';
    case SATURDAY = 'SATURDAY';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
