<?php

namespace App\Models\Enums;

enum ContactType: string
{
    case EMAIL = 'EMAIL';
    case PHONE = 'PHONE';
    case SOCIAL = 'SOCIAL';
    case WEBSITE = 'WEBSITE';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
