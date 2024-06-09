<?php

namespace App\Http\Resources;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->provider_id,
            'user' => new UserResource($this->user),
            'portrait_url' => $this->portrait_url,
            'badge' => $this->badge
        ];
    }
}
