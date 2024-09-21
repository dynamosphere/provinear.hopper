<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Shop;
use App\Models\User;
use App\Models\UserContact;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return env('APP_SPA_URL', env('APP_URL')). '/reset-password?token='.$token;
        });

        Scramble::extendOpenApi(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('Bearer', 'bearer')
            );
        });

        Relation::morphMap([
            ProductImage::$morph_type_name  => ProductImage::class,
            Product::$morph_type_name       => Product::class,
            UserContact::$morph_type_name   => UserContact::class,
            Category::$morph_type_name      => Category::class,
            Shop::$morph_type_name          => Shop::class
            // Add more mappings as needed for other models
        ]);
    }
}
