<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\TagResource;
use App\Http\Resources\VariationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'shop_id'                   => $this->shop_id,
            'product_name'              => $this->product_name,
            'product_description'       => $this->product_description,
            'brand_name'                => $this->brand_name,
            'available_quantity'        => $this->available_quantity,
            'unit_price'                => $this->unit_price,
            'currency'                  => new CurrencyResource($this->currency),
            'strikeout_price'           => $this->strikeout_price,
            'price_percentage_discount' => $this->price_percentage_discount,
            'unit_measure'              => $this->unit_measure,
            'opened_to_bargain'         => $this->opened_to_bargain,
            'created_at'                => $this->created_at,
            'modified_at'               => $this->modified_at,
            'average_rating'            => $this->average_rating,
            'like_count'                => $this->like_count,
            'dislike_count'             => $this->dislike_count,
            'images'                    => ProductImageResource::collection($this->images)
        ];
    }

}
