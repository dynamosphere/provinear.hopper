<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->shop_id,
            'shop_name' => $this->shop_name,
            'shop_description' => $this->shop_description,
            'address' => $this->address,
            'brand_logo_url' => $this->brand_logo_url,
            'brand_cover_image_url' => $this->brand_cover_image_url,
            'provider' => new ProviderResource($this->provider),
        ];
    }
}
