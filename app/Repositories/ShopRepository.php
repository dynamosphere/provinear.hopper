<?php

namespace App\Repositories;

use App\Models\Provider;
use App\Models\Shop;

class ShopRepository
{
    protected $shop;
    /**
     * Create a new class instance.
     */
    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
    }

    /**
     * Create a new shop for a vender
     */
    public static function createShop($shopData)
    {
        return Shop::create([
            'provider_id' => $shopData["provider_id"],
            'shop_name' => $shopData["shop_name"],
            'shop_description' => $shopData["shop_description"],
            'address'=> $shopData["address"],
            'brand_logo_url' => $shopData["brand_logo_url"],
            'brand_cover_image_url' => $shopData["brand_cover_image_url"]
        ]);
    }

    /**
     * Get all the shops that belongs to this provider
     */
    public function allProvidersShops(Provider $provider)
    {
        return $provider->shops;
    }

    /**
     * Create new shop
     */
    public function create($data)
    {
        return $this->shop->create($data);
    }

    /**
     * Update shop
     */
    public function update(Shop $shop, $data)
    {
        $shop->update($data);
        return $shop;
    }
}
