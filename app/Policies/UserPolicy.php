<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /** 
     * Check if the user given is the authenticated user
     */
    public function user(User $authUser, User $user)
    {
        return $authUser->user_id === $user->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
