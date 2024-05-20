<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to check if the user making the request owns a resource
 * 
 * @deprecated Please use the appropraite policy to authorize access to resources
 */
class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()){
            
            if (! $this->isUserOwner($request)){
                abort (Response::HTTP_FORBIDDEN, "The user ID provided is not for the current user");
            };
            
            if (! $this->isContactOwner($request)){
                abort (Response::HTTP_FORBIDDEN, "This contact does not belong to the user");
            };

            if (! $this->isAddressOwner($request)){
                abort (Response::HTTP_FORBIDDEN, "The address ID provided is not for the current user");
            };

            return $next($request);
        }
        abort(Response::HTTP_UNAUTHORIZED, "User is not authenticated");

    }

    /**
     * Check if the user is the owner of a contact
     */
    public function isContactOwner(Request $request)
    {
        $contact = $request->route('contact');
        $user = $request->user();

        // if there is contact param in the route
        if ($contact){

            // Check that the contact provided is for the user
            if(! $user->contacts()->where('contact_id', $contact->contact_id)->exists()){
                return false;  
            }
        }

        return true;
    }

    /**
     * Check that the user id in request is for the authenticatred user
     */
    public function isUserOwner(Request $request)
    {
        $userInRequest = $request->route('user');
        $user = $request->user();

        // if there is user param in the route
        if ($userInRequest){

            // Check that the user provided is for the user
            if(! $user->user_id == $userInRequest->user_id){
                return false;  
            }
        }

        return true;
    }

    /**
     * Check that the address id in request is for the authenticatred user
     */
    public function isAddressOwner(Request $request)
    {
        $addressInRequest = $request->route('address');
        $user = $request->user();

        // if there is address param in the route
        if ($addressInRequest){

            // Check that the address provided is for the user
            if(! $user->addresses()->where('address_id', $addressInRequest->address_id)->exists()){
                return false;  
            }
        }

        return true;
    }
}
