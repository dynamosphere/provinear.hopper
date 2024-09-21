<?php

namespace App\Casts;

use Brick\Math\Exception\NumberFormatException;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Money\Exception\UnknownCurrencyException;
use Brick\Money\Money;
use http\Exception\RuntimeException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class MoneyCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $code = $model->currency->iso_code;
        try {
            if ($value != null)
                return Money::of($value, $code);
            return $value;
        } catch (NumberFormatException|RoundingNecessaryException|UnknownCurrencyException $e) {
            Log::error('Error converting currency ' . $code . ' with value ' . $value . '. Exception: ' . $e->getMessage());
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value instanceof Money)
            return [
                $key => (string) $value->getAmount(),
                'currency_code' => $value->getCurrency()->getCurrencyCode()
            ];
        // Note: I think I should disallow setting prices on the database with Money object, just set directly
        // Just ensure that you are setting the currency to.
        // If you change your mind uncomment the block statement above.
        // I changed my mind
        return $value;
    }
}
