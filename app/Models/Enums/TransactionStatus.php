<?php

namespace App\Models\Enums;

enum TransactionStatus: string
{
    case PENDING = 'PENDING';
    case FAILED = 'FAILED';
    case SUCCESSFUL = 'SUCCESSFUL';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
