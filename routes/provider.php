<?php

/**
 * Product Management
 */
// Product Category
use App\Http\Controllers\Provider\ProviderCategoryController;
use App\Http\Controllers\Provider\ProviderCategoryProductController;
use App\Http\Controllers\Provider\ProviderProductController;
use App\Http\Controllers\Provider\ProviderProductImageController;
use App\Http\Controllers\Provider\ProviderProductVariationController;
use App\Http\Controllers\Provider\ProviderVariationController;
use App\Http\Controllers\Provider\ProviderShopCategory;
use App\Http\Controllers\Provider\ProviderShopProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('categories', ProviderCategoryController::class);
Route::apiResource('shops.categories.products', ProviderCategoryProductController::class)
    ->scoped(['product' => 'category'])->except('show');
Route::apiResource('shops.categories', ProviderShopCategory::class)->only('index');
Route::apiResource('shops.products', ProviderShopProductController::class)->only('index', 'store');
Route::apiResource('products', ProviderProductController::class)->except('store');
Route::apiResource('products.images', ProviderProductImageController::class)->only('index', 'store');
Route::get('products/images/{image}', [ProviderProductImageController::class, 'show'])->name('products.images.show');
Route::delete('products/images/{image}', [ProviderProductImageController::class, 'destroy'])->name('products.images.destroy');
Route::patch('products/images/{image}/tags/main', [ProviderProductImageController::class, 'tagImageMain'])->name('products.images.tags.main');
Route::apiResource('variations', ProviderVariationController::class)
    ->only('index', 'store', 'show', 'update', 'destroy');
Route::apiResource('products.variations', ProviderProductVariationController::class)->only('index', 'store');
Route::apiResource('products/variations', ProviderProductVariationController::class)->only('show', 'update', 'destroy');
