<?php

namespace App\Repositories;

use App\Models\UserAddress;
use App\Traits\HasCrudActions;

class UserAddressRepository
{
    use HasCrudActions;

    protected $address;
    protected $model;

    /**
     * Create a new class instance.
     */
    public function __construct(UserAddress $address)
    {
        $this->model  = $this->address = $address;
    }

    /**
     * Make an address primary.
     */
    public function setPrimary($id)
    {
        $address = $this->findById($id);

        if (! $address) {
            return false;
        }

        // Unset any other primary address for the user
        $this->model->where('user_id', $address->user_id)->update(['is_primary' => false]);

        // Set the selected address as primary
        $address->is_primary = true;
        $address->save();

        return $address;
    }

    /**
     * Get the primary address of a user
     */
    public function getPrimary($user)
    {
        if ($user){
            return  $user->addresses()->where('is_primary', true)->first();
        }
        return false;
    }

}
