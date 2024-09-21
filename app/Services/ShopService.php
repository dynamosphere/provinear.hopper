<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Provider;
use App\Models\Shop;
use App\Repositories\ShopRepository;

class ShopService
{
    protected $repository;
    /**
     * Create a new class instance.
     */
    public function __construct(ShopRepository $repo)
    {
        $this->repository = $repo;
    }

    /**
     * Get all shops owned by a vendor
     */
    public function providerShops(Provider $provider)
    {
        return $this->repository->allProvidersShops($provider);
    }

    /**
     * Determine if a provider can create new shops
     */
    public function canCreateStore(Provider $provider)
    {
        if($this->repository->allProvidersShops($provider)->count() == 0){
            return true;
        }
        return false;
    }

    /**
     * Update a shop
     */
    public function updateShop($shop, $data)
    {
        return $this->repository->update($shop, $data);
    }

    /**
     * Delete a shop
     */
    public function deleteShop($shop)
    {
        return $shop->delete();
    }

    /**
     * Create new shop for a provider
     */
    public function newShop($data)
    {
        return $this->repository->create($data);
    }

    /**
     * Upload a shop logo
     */
    public function uploadBrandLogo($request)
    {
        if ($request->hasFile('brand_logo')){
            return $request->uploadAndStoreFile($request->file('brand_logo'));
        };
        return null;
    }

    /**
     * Upload a shop cover image
     */
    public function uploadBrandCoverImage($request)
    {
        if ($request->hasFile('brand_cover_image')){
            return $request->uploadAndStoreFile($request->file('brand_cover_image'));
        };
        return null;
    }

    public function getProductCategoriesFromAUserShop($user, $shop)
    {
        return CategoryResource::collection(ProductCategory::join('product', 'product_category.product_id', '=', 'product.product_id')
            ->join('shop', 'product.shop_id', '=', 'shop.shop_id')
            ->join('category', 'product_category.category_id', '=', 'category.category_id')
            ->where('shop.provider_id', $user->provider->provider_id)
            ->where('product.shop', $shop)
            ->select('category.*')
            ->get());
    }

}
