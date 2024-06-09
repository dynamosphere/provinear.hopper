<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Enums\ProductApprovalStatus;
use App\Models\Enums\ProductStatus;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository implements IRepository
{

    public function findById(string $id)
    {
        return Product::findorfail($id);
    }

    public function findAll(int $perPage = 15)
    {
        return Product::paginate($perPage);
    }

    public function findAllFromShop(string $shop_id, int $perPage = 15)
    {
        return Product::paginate($perPage)
            ->where('shop_id', $shop_id);
//            ->where('product_status', ProductStatus::AVAILABLE)   // Note to self: Use this filter on public product exploration
//            ->where('approval_status', ProductApprovalStatus::APPROVED);
    }

    public function findProductsFromUserShop($provider_id, $shop_id, int $per_page = 15)
    {
        return Product::paginate($per_page)
            ->join('shop', 'shop.shop_id', '=', 'product.shop_id')
            ->where('product.shop_id', $shop_id)
            ->where('shop.provider_id', $provider_id)
            ->select('product.*')
            ->get();
    }

    public function findUserProductFromShopOrFail(string $provider_id, string $shop_id, string $product_id)
    {
        return Product::where('product.product_id', $product_id)
            ->join('shop', 'shop.shop_id', '=', 'product.shop_id')
            ->where('shop.provider_id', $provider_id)
            ->where('shop.shop_id', $shop_id)
            ->select('product.*')
            ->firstorfail();
    }

    public function findUserShopOrFail($provider_id, $shop_id)
    {
        return Shop::where('shop_id', $shop_id)
            ->where('provider_id', $provider_id)
            ->firstorfail();
    }

    public function findByProviderIdAndProductId($provider_id, $product_id)
    {
        return Product::join('shop', 'shop.shop_id', '=', 'product.shop_id')
            ->where('shop.provider_id', $provider_id)
            ->where('product.product_id', $product_id)
            ->select('product.*')
            ->firstorfail();
    }

    public function findByProviderId($provider_id)
    {
        return Product::join('shop', 'shop.shop_id', '=', 'product.shop_id')
            ->where('shop.provider_id', $provider_id)
            ->select('product.*')
            ->get();
    }

    public function findByProviderIdAndShopIdAndCategory($provider_id, $shop_id, Category $category): Collection
    {
        return $category->products()
            ->where('product.shop_id', $shop_id)
            ->join('shop', 'product.shop_id', '=', 'shop.shop_id')
            ->where('shop.provider_id', $provider_id)
            ->select('product.*')
            ->get();
    }

    public function findByProviderIdAndShopIdAndCategoryId($provider_id, $shop_id, $category_id): Collection
    {
        return ProductCategory::where('product_category.category_id', $category_id)
            ->join('product', 'product.product_id', '=', 'product_category.product_id')
            ->where('product.shop_id', $shop_id)
            ->join('shop', 'shop.shop_id', '=', 'product.shop_id')
            ->where('shop.provider_id', $provider_id)
            ->select('product.*')
            ->get();
    }

    public function deleteByProviderIdAndProductId($provider_id, $product_id): int
    {
        return DB::table('product')
            ->join('shop', 'shop.shop_id', '=', 'product.shop_id')
            ->where('shop.provider_id', $provider_id)
            ->where('product.product_id', $product_id)
            ->delete();
    }

    public function new(array $data)
    {
        return Product::create($data)->fresh();
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id): int
    {
        return Category::destroy($id);
    }

    public function remove($id): true
    {
        Product::update(['product_status' => ProductStatus::REMOVED])
            ->where('product_id', $id);
        return true;
    }
}
