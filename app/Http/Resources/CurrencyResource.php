<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code'              => $this->iso_code,
            'currency_name'     => $this->currency_name,
            'symbol'            => $this->symbol,
            'basic_unit'        => $this->basic_unit,
            'fractional_unit'   => $this->fractional_unit,
        ];
    }
}
