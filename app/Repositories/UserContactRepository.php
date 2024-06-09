<?php

namespace App\Repositories;

use App\Models\UserContact;
use App\Traits\HasCrudActions;

class UserContactRepository
{
    use HasCrudActions;

    protected $contact;
    protected $model;

    /**
     * Create a new class instance.
     */
    public function __construct(UserContact $contact)
    {
        $this->model  = $this->contact = $contact;
    }

}
