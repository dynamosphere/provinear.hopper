<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Provider;
use App\Models\Shop;


/**
 * Repository for managing vendor database queries and transctions
 */
class VendorRepository
{
    protected $provider;
    /**
     * Create a new class instance.
     */
    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Create new vendor profile
     * 
     * Create a new vendor profile for a particular user
     */
    public static function createVendor($user_id, $passport = "", $badge = "")
    {
        $provider = Provider::findorCreate([ 
            'user_id' => $user_id,
            'portrait_url' => $passport,
            'badge' => $badge
        ]);
        return $provider;
       
    }

    /**
     * Returns number of shops owned by a vendor
     */
    public function shopCount()
    {
        return $this->provider->shops->count();
    }


}
