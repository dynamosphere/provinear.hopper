<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Services\ProviderProductService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProviderCategoryProductController extends Controller
{
    private ProviderProductService $providerProductService;

    /**
     * @param ProviderProductService $providerProductService
     */
    public function __construct(ProviderProductService $providerProductService)
    {
        $this->providerProductService = $providerProductService;
    }


    /**
     * Get Provider Products in a shop belonging to a category
     */
    public function index(Request $request, $shop, $category): AnonymousResourceCollection
    {
        return $this->providerProductService->getShopProductsByUserByCategory($request->user(), $shop, $category);
    }

    /**
     * Attach Products in shop to category
     */
    public function store(Request $request, $shop, $category)
    {
        $validated = $request->validate([
            'products'      => 'required|array',
            'products.*'    => 'distinct'
        ]);
        $this->providerProductService->addUserProductsToCategory($request->user(), $shop, $category, $validated['products']);
        return response(ResponseAlias::HTTP_NO_CONTENT);
    }

    /**
     * Attach a Product to a category
     */
    public function update(Request $request, $shop, $category, $product)
    {
        $this->providerProductService->addUserProductsToCategory($request->user(), $shop, $category, array($product));
        return response(ResponseAlias::HTTP_NO_CONTENT);
    }

    /**
     * Detach a Product from a category
     */
    public function destroy(Request $request, $shop, $category, $product)
    {
        $this->providerProductService->detachUserProductsToCategory($request->user(), $shop, $category, array($product));
        return response(ResponseAlias::HTTP_NO_CONTENT);
    }
}
