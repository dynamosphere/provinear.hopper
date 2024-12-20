<?php

use App\Http\Middleware\UserIsAnAdmin;
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
            Route::middleware('api')
                ->prefix('api/v1/admin')
                ->group(base_path('routes/admin.php'));
            Route::middleware('api')
                ->prefix('api/v1/public')
                ->group(base_path('routes/public.php'));
            Route::middleware('api')
                ->prefix('api/v1/provider')
                ->group(base_path('routes/provider.php'));

        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->web(replace: [
            TrustProxies::class => MyTrustProxies::class,
        ]);
        $middleware->trustHosts(at: [env('APP_HOST', 'localhost:8000')]);
        $middleware->alias([
            "provider" => UserIsAProvider::class,
            "admin"    => UserIsAnAdmin::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
