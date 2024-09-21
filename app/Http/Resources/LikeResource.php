<?php

namespace App\Http\Resources;

use App\Http\Resources\User\UserNameResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'like_id'       => $this->like_id,
            'object_id'     => $this->object_id,
            'object_type'   => $this->object_type,
            'liked'         => $this->liked,
            'by'            => new UserNameResource($this->user)
        ];
    }
}
