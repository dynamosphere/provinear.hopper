<?php

namespace App\Services;

use App\Models\Provider;
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
        
    }

}
