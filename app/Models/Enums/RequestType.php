<?php

namespace App\Models\Enums;

enum RequestType: string
{
    case PRODUCT = 'PRODUCT';
    case SERVICE = 'SERVICE';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
