<?php

namespace App\Models\Enums;

enum OrderStatus: string
{
    case PENDING = 'PENDING';
    case READY_TO_SHIP = 'READY_TO_SHIP';
    case SHIPPED = 'SHIPPED';
    case CANCELED = 'CANCELED';
    case COMPLETED = 'COMPLETED';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
