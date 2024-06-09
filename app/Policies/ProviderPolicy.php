<?php

namespace App\Policies;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProviderPolicy extends AbstractOwnerPolicy
{
    protected function getModelType(): string
    {
        return Provider::class;
    }

    public function createShop(User $user, Provider $provider)
    {
        if ($user->user_id === $provider->user->user_id){

            // check if their shop count is less than 1
            // multiple shops is only for subscribed user
            // which will be taken care off in the future
    
            $shopCount = $provider->shops()->count();
            if ($shopCount === 0){
                return Response::allow();
            }
            return Response::deny("Upgrade your subscription to create a new shop");
        }
        return Response::denyAsNotFound("Provider account not found");
    }
}
