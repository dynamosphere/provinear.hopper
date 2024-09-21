<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'category_id'           => $this->category_id,
            'category_name'         => $this->category_name,
            'category_description'  => $this->category_description,
            'created_at'            => $this->created_at,
            'modified_at'           => $this->modified_at,
            'parent_id'             => $this->parent_id
        ];
    }
}
