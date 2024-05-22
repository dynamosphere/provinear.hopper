<?php

namespace App\Policies;

use App\Models\UserContact;

class UserContactPolicy extends AbstractOwnerPolicy
{

    protected function getModelType(): string
    {
        return UserContact::class;
    }
}
