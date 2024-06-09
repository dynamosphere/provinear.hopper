<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\VariationResource;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_variation_id'  => $this->product_variation_id,
            'product_id'            => $this->product_id,
            'variation'             => new VariationResource($this->variation),
            'variation_value'       => $this->variation_value,
            'variation_price'       => $this->variation_price,
            'variation_detail'      => $this->variation_detail,
            'created_at'            => $this->created_at,
            'modified_at'           => $this->modified_at,
        ];
    }
}
