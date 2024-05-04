<?php

namespace App\Http\Middleware;

// use Closure;
use Illuminate\Http\Middleware\TrustProxies as BaseTrustProxies;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;

class MyTrustProxies  extends BaseTrustProxies
{
    /**
     * The trusted proxies for the application.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = "*";
}
