<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->address_id,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'house_number'  => $this->house_number,// or room number
            'street'        => $this->street,
            'city'          => $this->city,
            'state'         => $this->state,
            'postal_code'   => $this->postal_code,
            'phone'         => $this->phone,
            'is_primary'    => $this->is_primary,
            'user'          => new UserResource($this->whenLoaded('user')),  
        ];
    }
}
