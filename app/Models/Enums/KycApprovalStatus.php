<?php

namespace App\Models\Enums;

enum KycApprovalStatus: string
{
    case PENDING = 'PENDING';
    case REJECTED = 'REJECTED';
    case APPROVED = 'APPROVED';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
