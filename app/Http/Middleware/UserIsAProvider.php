<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

// use Symfony\Component\HttpFoundation\Response;

class UserIsAProvider
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (Illuminate\Http\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Check if the authenticated user is a provider
            if ($request->user()->provider) {
                $request->route()->setParameter('provider', $request->user()->provider);
                return $next($request);
            }
        }
        
        abort(Response::HTTP_UNAUTHORIZED, "User is not a service provider");
    }
}
