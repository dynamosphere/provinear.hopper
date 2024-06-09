<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductDetailResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProviderProductDetailResource;
use App\Services\ProviderProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProviderProductController extends Controller
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
     * Get provider products.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return $this->productService->getProviderProducts($request->user()->provider->provider_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $product): ProviderProductDetailResource
    {
        return $this->productService->getProviderProductById($request->user()->provider->provider_id, $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $product)
    {
        // Todo: Find out to implement from the UI designs
    }

    /**
     * Remove User Product.
     */
    public function destroy(Request $request, $product): JsonResponse
    {
        if ($this->productService->deleteProviderProduct($request->user()->provider->provider_id, $product))
            return response()->json(['message' => 'Product deleted successfully']);
        return response(status: ResponseAlias::HTTP_NOT_FOUND)->json(['message' => 'Deletion failed']);
    }
}
