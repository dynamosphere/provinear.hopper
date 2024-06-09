<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Auth\Access\Response;

class UserAddressPolicy extends AbstractOwnerPolicy
{
    
    protected function getModelType(): string
    {
        return UserAddress::class;
    }

    public function setPrimary(User $user, UserAddress $address)
    {
        return $user->user_id === $address->user->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }


}
