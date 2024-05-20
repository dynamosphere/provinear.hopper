<?php

namespace App\Services;

use App\Repositories\UserAddressRepository;
use App\Repositories\UserContactRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;

class UserService
{
    protected $userAddressRepository;
    protected $userContactRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(UserContactRepository $userContactRepository, UserAddressRepository $userAddressRepository)
    {
        $this->userAddressRepository = $userAddressRepository;
        $this->userContactRepository = $userContactRepository;
    }

    /**
     * Create a new contact for the user
     */
    public function newUserContact($data)
    {
        return $this->userContactRepository->create($data);
    }

    /**
     * Update a user contact
     */
    public function updateUserContact($contact, $data)   
    {
        return $this->userContactRepository->update($contact->contact_id, $data);
    }

    /**
     * Delete a user contact
     */
    public function deleteUserContact($contact)
    {
        return $this->userContactRepository->delete($contact->contact_id);
    }

    /**
     * Store a new address for a user
     */
    public function newUserAddress($data)
    {
        // if this is the first address
        if (! $this->userAddressRepository->findByColumn('user_id', $data['user_id'])){
            // Set address as primary
            $data['is_primary'] = true;
        }else{
            $data['is_primary'] = false;
        }
        return $this->userAddressRepository->create($data);
    }

    /**
     * Update an address of a user
     */
    public function updateUserAddress($address, $data)
    {
        return $this->userAddressRepository->update($address->address_id, $data);
    }

    /**
     * Delete an address for a user
     */
    public function deleteUserAddress($address)
    {
        if ($address->is_primary){
            throw New AuthorizationException("You can't delete a primary address");
        }
        return $this->userAddressRepository->delete($address->address_id);
    }

    /**
     * Make an address primary
     */
    public function setAddressPrimary($address)
    {
        if ($address->is_primary){
            throw new InvalidArgumentException("This address is already made primary");
        }else{
            throw new ModelNotFoundException("Address does not exist");
        }
        return $this->userAddressRepository->setPrimary($address->address_id);
    }
    
    /**
     * Get Primary address of a user
     */
    public function getPrimaryAddress($user)
    {
        return $this->userAddressRepository->getPrimary($user);
    }
}
