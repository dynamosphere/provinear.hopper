<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Services\ProviderProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProviderShopProductController extends Controller
{
    private ProviderProductService $productService;

    /**
     * @param ProviderProductService $productService
     */
    public function __construct(ProviderProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display products from a shop
     */
    public function index(Request $request, $shop): AnonymousResourceCollection
    {
        $perPageParam = $request->query('per_page');
        $perPage = is_numeric($perPageParam) ? intval($perPageParam) : 15;
        return  $this->productService->getUserShopProducts($request->user(), $shop, $perPage);
    }

    /**
     * Add a new Product to a Shop
     */
    public function store(ProductRequest $request, $shop): \App\Http\Resources\Product\ProviderProductDetailResource
    {
        $data = $request->validated();

        $images = [];

        foreach (['main_image', 'image_1', 'image_2', 'image_3'] as $file_key) {
            if ($request->hasFile($file_key))
                $images[$file_key] = $request->file($file_key);
        }

        return $this->productService->addProductWithImages($request->user(), $shop, $data, $images);
    }
}
