<?php

namespace App\Models\Enums;

enum LikeableObject: string
{
    case PRODUCT = 'PRODUCT';
    case RATING = 'RATING';
    case PROVIDER = 'PROVIDER';
    case SHOP = 'SHOP';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
