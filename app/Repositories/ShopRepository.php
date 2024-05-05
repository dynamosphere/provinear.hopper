<?php

namespace App\Repositories;

use App\Models\Shop;

class ShopRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
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
}
