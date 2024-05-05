<?php

namespace App\Models\Enums;

enum RateableObject: string
{
    case PROVIDER = 'PROVIDER';
    case SHOP = 'SHOP';
    case PRODUCT = 'PRODUCT';
    case MARKETPLACE = 'MARKETPLACE';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
