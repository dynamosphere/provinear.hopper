<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminCurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code'                      => $this->iso_code,
            'currency_name'             => $this->currency_name,
            'symbol'                    => $this->symbol,
            'base_unit'                 => $this->base_unit,
            'fractional_unit'           => $this->fractional_unit,
            'fractional_to_basic_rate'  => $this->fractional_to_basic_rate,
            'admin_id'                  => $this->admin_id,
            'created_at'                => $this->created_at,
            'modified_at'               => $this->created_at

        ];
    }
}
