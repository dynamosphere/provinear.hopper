<?php

namespace App\Http\Resources;

use App\Http\Resources\Product\ProductVariationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'variation_id'      => $this->variation_id,
            'name'              => $this->name,
            'description'       => $this->description,
            'variations'        => ProductVariationResource::collection($this->product_variations),
            'created_at'        => $this->created_at,
            'modified_at'       => $this->modified_at
        ];
    }
}
