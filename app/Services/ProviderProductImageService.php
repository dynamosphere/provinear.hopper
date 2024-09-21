<?php

namespace App\Services;

use App\Http\Resources\Product\ProductImageResource;
use App\Models\ProductImage;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class ProviderProductImageService
{
    private ProviderProductService $productService;
    private TagService $tagService;

    /**
     * @param ProviderProductService $productService
     */
    public function __construct(ProviderProductService $productService, TagService $tagService)
    {
        $this->productService = $productService;
        $this->tagService = $tagService;
    }

    public function getProviderProductImages($provider_id, $product_id): AnonymousResourceCollection
    {
        return ProductImageResource::collection(ProductImage::join('product', 'product.product_id', '=', 'product_image.product_id')
            ->join('shop', 'shop.shop_id', 'product.shop_id')
            ->where('shop.provider_id', $provider_id)
            ->where('product.product_id', $product_id)
            ->get());
    }

    public function addAProductImages($provider_id, $product_id, $images): AnonymousResourceCollection
    {
        $product = $this->productService->getProviderProductById($provider_id, $product_id);
        return ProductImageResource::collection(array_map(fn($image) => $this->productService->createAndSaveProductImage($product, $image), $images));
    }

    public function getProductImageById($provider_id, $image_id): ProductImageResource
    {
        return new ProductImageResource($this->getProductImageModelByProvider($provider_id, $image_id));
    }

    public function deleteProductImage($provider_id, $image_id): int
    {
        return DB::table('product')
            ->join('product', 'product.product_id', '=', 'product_image.product_id')
            ->join('shop', 'shop.shop_id', '=', 'product.shop_id')
            ->where('shop.provider_id', $provider_id)
            ->where('product_image.product_image_id', $image_id)
            ->delete();
    }

    public function tagImageMain($provider_id, $image_id): true
    {
        $image = $this->getProductImageModelByProvider($provider_id, $image_id);
        $all_images = $image->product->images;
        foreach ($all_images as $p_image)
            $this->tagService->untagObject($p_image, 'main_image');
        return $this->tagService->tagObject($image, ['main_image']);
    }

    private function getProductImageModelByProvider($provider_id, $image_id)
    {
        return ProductImage::join('product', 'product.product_id', '=', 'product_image.product_id')
            ->join('shop', 'shop.shop_id', '=', 'product.shop_id')
            ->where('shop.provider_id', $provider_id)
            ->where('product_image.product_image_id', $image_id)
            ->select('product_image.*')
            ->firstofail();
    }

}
