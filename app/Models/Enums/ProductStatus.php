<?php

namespace App\Models\Enums;

enum ProductStatus: string
{
    case AVAILABLE = 'AVAILABLE';
    case OUT_OF_STOCK = 'OUT_OF_STOCK';
    case REMOVED = 'REMOVED';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
