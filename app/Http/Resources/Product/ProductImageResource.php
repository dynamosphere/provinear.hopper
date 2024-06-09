<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\TagResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'image_id' => $this->product_image_id,
            'image_url' => Storage::url($this->image_url),
            'tags'      => TagResource::collection($this->tags),
        ];
    }
}
