<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserIsAnAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (ResponseAlias) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {

            if($request->user()->admin) {
                return $next($request);
            }
        }
        abort(ResponseAlias::HTTP_FORBIDDEN, 'You are unauthorised to perform this operation');
    }
}
