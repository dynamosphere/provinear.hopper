<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductImageResource;
use App\Services\ProviderProductImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProviderProductImageController extends Controller
{
    private ProviderProductImageService $productImageService;

    /**
     * @param ProviderProductImageService $productImageService
     */
    public function __construct(ProviderProductImageService $productImageService)
    {
        $this->productImageService = $productImageService;
    }

    /**
     * Get All Product Images
     */
    public function index(Request $request, $product): AnonymousResourceCollection
    {
        return $this->productImageService->getProviderProductImages($request->user()->provider->provider_id, $product);
    }

    /**
     * Add a new Product image
     */
    public function store(Request $request, $product): AnonymousResourceCollection
    {
        $request->validate([
            'images'    => 'required|array',
            'images.*'  => 'required|image|distinct|max:4096'
        ]);
        $images = $request->file('images');
        return $this->productImageService->addAProductImages($request->user()->provider->provider_id, $product, $images);
    }

    /**
     * Get a product image by its Id
     */
    public function show(Request $request, $image): ProductImageResource
    {
        return $this->productImageService->getProductImageById($request->user()->provider->provider_id, $image);
    }

    /**
     * Delete a product image with its Id
     */
    public function destroy(Request $request, $image)
    {
        $this->productImageService->deleteProductImage($request->user()->provider->provider_id, $image);
        return response(ResponseAlias::HTTP_NO_CONTENT);
    }

    /**
     * Tag a Product Image as main
     */
    public function tagImageMain(Request $request, $image)
    {
        $this->productImageService->tagImageMain($request->user()->provider->provider_id, $image);
        return response(ResponseAlias::HTTP_NO_CONTENT);
    }
}
