<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


/**
 * @deprecated Please use the appropraite policy to authorize access to resources
 *
 */
class UserIsAProvider
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Get the current provider
            $provider = $request->user()->provider;

            // Check if user is a provider
            if ($provider) {
                $providerInRequest = $request->route('provider');
                $shopInRequest = $request->route('shop');

                // if there is a provider in the route
                if ($providerInRequest){

                    // Check that the provider provided in route is of the current user(provider) making the request
                    if (!$provider->provider_id == $providerInRequest){
                        abort(ResponseAlias::HTTP_FORBIDDEN, "Provider ID provided is not of the current user");
                    }
                }

                // if there is shop in the route
                if ($shopInRequest){
                    $provider = $providerInRequest ?? $provider;

                    // Check that the shop provided is for the provider
                    if(!$provider->shops()->where('shop_id', $shopInRequest)->exists()){
                        abort(ResponseAlias::HTTP_FORBIDDEN, "This shop does not belong to the provider");
                    }
                }
                return $next($request);
            }

            abort(ResponseAlias::HTTP_FORBIDDEN, "User is not a service provider");
        }
        abort(ResponseAlias::HTTP_UNAUTHORIZED, "User is not authenticated");

    }
}
