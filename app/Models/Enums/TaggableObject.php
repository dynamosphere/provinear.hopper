<?php

namespace App\Models\Enums;

enum TaggableObject: string
{
    case CONTACT = 'CONTACT';
    case PRODUCT = 'PRODUCT';
    case CATEGORY = 'CATEGORY';
    case SHOP = 'SHOP';
    case PRODUCT_IMAGE = 'PRODUCT_IMAGE';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
