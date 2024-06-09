<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Services\ShopService;
use Illuminate\Http\Request;

class ProviderShopCategory extends Controller
{
    private ShopService $shopService;

    /**
     * @param ShopService $shopService
     */
    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $shop)
    {
        return $this->shopService->getProductCategoriesFromAUserShop($request->user(), $shop);
    }

}
