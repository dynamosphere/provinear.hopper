<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Middleware\TrustProxies;
use App\Http\Middleware\MyTrustProxies;
use App\Http\Middleware\OwnerMiddleware;
use App\Http\Middleware\UserIsAProvider;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api/v1')
                ->group(base_path('routes/api.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->web(replace: [
            TrustProxies::class => MyTrustProxies::class,
        ]);
        $middleware->trustHosts(at: [env('APP_HOST', 'localhost:8000')]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
