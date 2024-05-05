<?php

namespace App\Services;

use App\Repositories\VendorRepository;
use App\Repositories\ShopRepository;

class VendorService
{
    protected $vendorRepo;
    /**
     * Create a new class instance.
     */
    public function __construct(VendorRepository $vendorRepo)
    {
        $this->vendorRepo = $vendorRepo;
    }

    /**
     * Register a new vendor
     */
    public static function registerVendor($data)
    {
        return VendorRepository::createVendor($data['user_id'], $data['passport'], $data['badge']);
    }

    /**
     * Create a new shop for a vendor
     */
    public function newShop($shopData){
        //check vendor has a shop already
        if ($this->vendorRepo->shopCount() > 0 ){
            return null;
        }
        return ShopRepository::createShop($shopData);
    }

    /**
     * Add product to vendor shop
     */

    /**
     * Remove product from a shop
     */

    /**
     * Publish a product in the shop
     */

    /**
     * Change product image in a shop
     */

    /**
     * Add images to a product
     */

    
}
