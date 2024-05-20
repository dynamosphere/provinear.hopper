<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserContactController;
use Illuminate\Support\Facades\Route;

/**
 * API Authentication guard - not working currently -
 */
Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('/reset-password', [AuthenticationController::class, 'resetPassword'])->name('reset-password');

});

/**
 * User Authentication
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthenticationController::class, 'user']);
    Route::get('/logout', [AuthenticationController::class, 'logout'])->name('auth.logout');
    Route::get('/email/verify/{id}/{hash}', [AuthenticationController::class, 'verifyEmail']
    )->middleware(['auth:sanctum', 'signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [AuthenticationController::class, 'resendVerificationEmail'])
    ->middleware(['throttle:6,1'])->name('verification.send');
});

/**
 * User management
 * 
 * * user management
 * - create user
 * - suspend account 
 * - update account
 * - change and reset password
 * - crud user contacts (can't update or delete except primary)
 * - - crud delivery address info (can't update or delete primary)
 * - get provider
 */
Route::apiResource('users.contacts', UserContactController::class)->middleware(['auth:sanctum'])->shallow();
Route::apiResource('users.addresses', UserAddressController::class)->middleware(['auth:sanctum'])->shallow();
Route::post('/address/{address}/primary', [UserAddressController::class, 'makePrimary'])->middleware(['auth:sanctum'])->name('addresses.setprimary');
Route::get('users/{user}/addresses/primary', [UserAddressController::class, 'getPrimary'])->middleware(['auth:sanctum'])->name('addresses.getprimary');


/***
 * Provider Management
 */
Route::controller(ProviderController::class)->middleware('auth:sanctum')->prefix('provider')->name('provider.')->group(function () {
    Route::get('/me', 'currentProvider')->name('me');
    Route::post("/activate-account", 'store')->name('activate-account');
    Route::put("/update-picture", 'updatePicture')->middleware('provider')->name('update-picture');
});

/**
 * Shop Management
 */
Route::apiResource('providers.shops', ShopController::class)->middleware(['auth:sanctum'])->shallow();
Route::controller(ShopController::class)->middleware(['auth:sanctum'])->prefix('shops')->name('shops.')->group(function () {
    Route::put("/{shop}/update-cover-image", 'updateCoverImage')->name('update-cover-image');
    Route::put("/{shop}/update-logo", 'updateLogo')->name('update-logo');
    // Route::put("/{shop}/update-opening-hours", 'updateOpeningHours')->name('update-opening-hours');
    // Route::get("/{shop}/opening-hours", 'getOpeningHours')->name('get-opening-hours');
});

/**
 * Product Management
 */
// Route::apiResource('shops.products', ProductController::class)->shallow()->middleware(['auth:sanctum', 'provider']);




/**
 * shop management
 * - crud shop (use crudTrait)
 * - update shop cover image and logo (use Imagetrait)
 * - update shop opening hours
 * 
 * product management
 * - crud product
 * - crud product category
 * - product tagging
 * - product rating
 * - product categorization (add or remove product to a category)
 * - product promotion crud
 * - add or remove promotion to product
 * - add, remove, update product image
 * - change product status (in stock, out of stock, or removed)
 * - review product (approve or decline a product with comment)
 * - change delivery fulfillment option (store under product managemtn)
 * 
 * order management
 * - cart management
 * - - add product to cart
 * - - remove product from cart
 * - - clear cart
 * - - checkout cart
 * - create an order (accepts list of product to create order id for)
 * - make payment for order*
 * - check payment status for order
 * - check order status for buyer
 * - check payment status for order for a specific buyers
 * - get all order for a buyer (order history)
 * - get all order a particular vendor
 * - vendor accept or reject order (initiate refund when sellers reject ordr, reduce seller fulfuillment score)
 * - confirm delivery (for sellers)
 * - attach billing address to order
 * - change delivery fulfillment option (store under order managemtn)
 * 
 * rating management
 * - give feedback on order (rate and give quality score and comment) (use HasRating trait)
 * - rate a rating (helpful or not helpful, upvote or downvote a rating) (attach user to their ratings)
 * 
 * Tag management (use trait HasTag)
 * - crud tag (only delete tags you created so far it is not used)
 * - tag object (attach tags to objects)
 * 
 * provider management
 * - activate provider account
 * - update provider pictures
 * 
 * kyc management
 * - submit kyc
 * - check kyc status
 * - approve or decline kyc with comment
 * - update kyc verification option (add or remove kyc options) admin
 * 
 * user management
 * - create user
 * - suspend account 
 * - update account
 * - change and reset password
 * - crud user contacts (can't update or delete except primary)
 * - - crud delivery address info (can't update or delete primary)
 * - get provider
 * 
 * product exploration
 * - get a product
 * - search for product with nlp
 * - filter products 
 */