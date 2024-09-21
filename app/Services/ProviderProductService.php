<?php

namespace App\Services;

use App\Http\Resources\LikeResource;
use App\Http\Resources\Product\ProductDetailResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProviderProductDetailResource;
use App\Http\Resources\RatingResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tag;
use App\Repositories\ProductRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class ProviderProductService
{
    private ProductRepository $productRepository;
    private TagService $tagService;
    private LikeService $likeService;
    private RatingService $ratingService;

    /**
     * @param ProductRepository $productRepository
     * @param TagService $tagService
     */
    public function __construct(ProductRepository $productRepository,
                                TagService $tagService,
                                LikeService $likeService,
                                RatingService $ratingService)
    {
        $this->productRepository = $productRepository;
        $this->tagService = $tagService;
        $this->likeService = $likeService;
        $this->ratingService = $ratingService;
    }

    // Context User Specific services

    public function addProduct($user, $shop_id, array $data): ProviderProductDetailResource
    {
        $shop = $this->productRepository->findUserShopOrFail($user->provider->provider_id, $shop_id);

        $data['shop_id'] = $shop->shop_id;
        $product = $this->productRepository->new($data);
        $this->saveCategoriesAndTags($product, $data);
        return new ProviderProductDetailResource($product);
    }

    public function addProductWithImages($user, $shop_id, array $data, array $images): ProviderProductDetailResource
    {
        $shop = $this->productRepository->findUserShopOrFail($user->provider->provider_id, $shop_id);

        $data['shop_id'] = $shop->shop_id;
        $product = $this->productRepository->new($data);
        $this->saveCategoriesAndTags($product, $data);

        foreach ($images as $file_key => $image) {
            $product_image = $this->createAndSaveProductImage($product, $image);

            if ($file_key == 'main_image') {
                $product_image->tags()->save(Tag::find('main_image'));
            }
        }

        return new ProviderProductDetailResource($product);
    }

    public function createAndSaveProductImage($product, $image)
    {
        $path = $image->store('shops/' . $product->shop_id . '/products/images');

        return ProductImage::create([
            'product_id' => $product->product_id,
            'image_url' => $path
        ]);
    }

    public function getUserShopProducts($user, $shop_id, int $perPage): AnonymousResourceCollection
    {
        return ProductResource::collection($this->productRepository->findProductsFromUserShop($user->provider->provider_id, $shop_id, $perPage));
    }

    public function getShopProductsByUserByCategory($user, $shop_id, $category_id): AnonymousResourceCollection
    {
        $category = Category::findorfail($category_id);
        $products = $this->productRepository->findByProviderIdAndShopIdAndCategory($user->provider->provider_id, $shop_id, $category);
        
        return  ProductResource::collection($products);
    }

    public function likeProduct($product_id, $user, bool $liked): LikeResource
    {
        $product = Product::findorfail($product_id);
        return $this->likeService->likeObject($product, $user, $liked);
    }

    public function rateProduct($product_id, array $data, $user): RatingResource
    {
        $product = Product::findorfail($product_id);
        return $this->ratingService->rateObject($product, $user, $data);
    }

    public function addUserProductsToCategory($user, $shop_id, $category_id, $product_ids): true
    {
        $products = array_map(
            fn($id) => $this->productRepository->findUserProductFromShopOrFail($user->provider->provider_id, $shop_id, $id),
            $product_ids
        );
        $category = Category::findorfail($category_id);
        foreach ($products as $product) $product->categories()->save($category);
        return true;
    }

    public function detachUserProductsToCategory($user, $shop_id, $category_id, $product_ids): true
    {
        $products = array_map(
            fn($id) => $this->productRepository->findUserProductFromShopOrFail($user->provider->provider_id, $shop_id, $id),
            $product_ids
        );
        $category = Category::findorfail($category_id);
        foreach ($products as $product) $product->categories()->detach($category);
        return true;
    }




    // Other non-context user bound services

    public function getProviderProducts($provider_id): AnonymousResourceCollection
    {
        return ProductResource::collection($this->productRepository->findByProviderId($provider_id));
    }

    public function getProviderProductById($provider_id, $product_id): ProviderProductDetailResource
    {
        return new ProviderProductDetailResource(
            $this->productRepository->findByProviderIdAndProductId($provider_id, $product_id));
    }
    public function getProductById($product_id): ProductDetailResource
    {
        return new ProductDetailResource($this->productRepository->findById($product_id));
    }

    public function tagProduct($product_id, array $tag_ids): true
    {
        $product = Product::findorfail($product_id);
        return $this->tagService->tagObject($product, $tag_ids);
    }

    public function untagProduct($product_id, $tag_id): true
    {
        $product = Product::findorfail($product_id);
        return $this->tagService->untagObject($product, $tag_id);
    }

    public function addProductsToCategories($product_ids, $category_ids): true
    {
        $products = array_map(fn($id) => Product::findorfail($id), $product_ids);
        $categories = array_map(fn($id) => Category::findorfail($id), $category_ids);
        foreach ($products as $product) $product->categories()->saveMany($categories);
        return true;
    }

    public function detachProductsFromCategories($product_ids, $category_ids): true
    {
        $products = array_map(fn($id) => Product::findorfail($id), $product_ids);
        $categories = array_map(fn($id) => Category::findorfail($id), $category_ids);
        foreach ($products as $product) $product->categories()->detach($categories);
        return true;
    }

    public function markProductRemoved($product_id): true
    {
        return $this->productRepository->remove($product_id);
    }

    public function deleteProduct($product_id): int
    {
        return $this->productRepository->delete($product_id);
    }

    public function deleteProviderProduct(string $provider_id, string $product_id): int
    {
        return $this->productRepository->deleteByProviderIdAndProductId($provider_id, $product_id);
    }



    // Private methods

    private function saveCategoriesAndTags(Product $product, array $data): void
    {
        if (array_key_exists('categories', $data)) {
            $product->categories()->saveMany(array_map(fn($id) => Category::find($id), $data['categories']));
        }

        if (array_key_exists('tags', $data)) {
            $this->tagService->tagObject($product, $data['tags']);
        }
    }
}
