<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressRequest;
use App\Http\Resources\UserAddressResource;
use App\Models\User;
use App\Models\UserAddress;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use InvalidArgumentException;

class UserAddressController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Get all the address of the user
     * 
     * @param User $user
     * 
     */
    public function index(User $user)
    {
        return UserAddressResource::collection($user->addresses);
    }


     /**
     * Add a new address to the user's account
     * 
     * @param UserAddressRequest $request
     * @param User $user
     * 
     */
    public function store(UserAddressRequest $request, User $user)
    {
        $data = $request->validated();
        $data['user_id'] = $user->user_id;
        $address = $this->userService->newUserAddress($data);

        return new UserAddressResource($address);
        
    }

    /**
     * Get a particular address using it's id.
     * 
     * @param UserAddress $address
     */
    public function show(UserAddress $address)
    {
        return new UserAddressResource($address);
    }


    /**
     * Update an address.
     * 
     * @param UserAddressRequest $request
     * @param UserAddress $address
     * 
     */
    public function update(UserAddressRequest $request, UserAddress $address)
    {
        $data = $request->validated();
        $this->userService->updateUserAddress($address, $data);

        return  response()->json(['message' => 'Address updated successfully']);
    }

    /**
     * Make an address primary using it's id.
     * 
     * This will unset any other address as primary address
     * 
     * @param UserAddress $address
     */
    public function makePrimary(UserAddress $address)
    {
        try{
            if ($this->userService->setAddressPrimary($address)){
                return response()->json(['message' => 'Address made primary successfully'], 200);
            }
        }catch (InvalidArgumentException $e){
            return response()->json(['message' => $e->getMessage()], 409);
        }
        return response()->json(['message' => 'We couldn\'t make this address primary'], 422);
    }

    /**
     * Get the user's primary address
     * 
     * @param UserAddress $address
     */
    public function getPrimary(User $user)
    {
        return new UserAddressResource($this->userService->getPrimaryAddress($user));
    }

    /**
     * Delete a user address.
     * 
     * You can't delete a primary address.
     */
    public function destroy(UserAddress $address)
    {
        try{

            if ($this->userService->deleteUserAddress($address))
            {
                return response()->json([
                    'message' => 'Address deleted successfully'
                ]);
            }
        }catch (AuthorizationException $e){
            return response()->json([
                'message' => $e->getMessage(),
            ], 403);
        }
    }
}
