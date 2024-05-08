<?php

namespace App\Notifications\Enums;

enum TelegramMessageType: string
{
    case NEW_USER = 'NEW_USER';
    case PROVIDER_ACCOUNT_ACTIVATED = 'PROVIDER_ACCOUNT_ACTIVATED';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
