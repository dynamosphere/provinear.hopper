<?php

namespace App\Http\Resources;

use App\Http\Resources\User\UserNameResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'rating_id'         => $this->rating_id,
            'object_id'         => $this->object_id,
            'object_type'       => $this->object_type,
            'comment'           => $this->comment,
            'rate'              => $this->rate,
            'by'                => new UserNameResource($this->user),
            'up_vote_count'     => $this->like_count,
            'down_vote_count'   => $this->dislike_count,
            'parent_id'         => $this->parent_id
        ];
    }
}
