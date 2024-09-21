<?php

namespace App\Casts;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\DivisionByZeroException;
use Brick\Math\Exception\NumberFormatException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class BigDecimalCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        try {
            return BigDecimal::of($value);
        } catch (DivisionByZeroException|NumberFormatException $e) {
            Log::error('error casting to decimal. Value: ' . $value . ' Exception: ' . $e->getMessage());
        }
        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value instanceof BigDecimal)
            return (string) $value;
        return $value;
    }
}
