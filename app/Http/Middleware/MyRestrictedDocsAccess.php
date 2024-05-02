<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MyRestrictedDocsAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, \Closure $next)
    {
        if (app()->environment('local')) {
            return $next($request);
        }
        if (Auth::check()){
            $user = $request->user();
    
            if (in_array($user->email, ['dlktimothy@gmail.com'])) {
                return $next($request);
            }
            abort(403);
        }else{
            return redirect(route('login'));
        }


    }
}
