<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'admin_id'      => $this->admin_id,
            'user'          => new UserResource($this->user)
        ];
    }
}
