<?php

namespace App\Services;

use App\Http\Resources\Product\ProductVariationResource;
use App\Http\Resources\VariationResource;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Variation;
use App\Repositories\ProductRepository;
use App\Repositories\VariationRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class VariationService
{
    private VariationRepository $variationRepository;
    private ProductRepository $productRepository;

    /**
     * @param VariationRepository $variationRepository
     */
    public function __construct(VariationRepository $variationRepository, ProductRepository $productRepository)
    {
        $this->variationRepository = $variationRepository;
        $this->productRepository = $productRepository;
    }

    public function listVariations(): AnonymousResourceCollection
    {
        return VariationResource::collection(Variation::all());
    }

    public function addVariation(array $data, $user): VariationResource
    {
        $data['owner_id'] = $user->user_id;
        return new VariationResource($this->variationRepository->new($data));
    }

    public function updateVariation($id, array $data): VariationResource
    {
        return new VariationResource($this->variationRepository->update($id, $data));
    }

    public function getVariationById($variation_id): VariationResource
    {
        return new VariationResource($this->variationRepository->findById($variation_id));
    }

    public function removeVariation($id): int
    {
        return $this->variationRepository->delete($id);
    }

    public function getVariationsByUser(string $user_id)
    {
        return VariationResource::collection(Variation::where('owner_id', $user_id)
            ->get());
    }

    public function getVariationByUser(string $user_id, $variation_id): VariationResource
    {
        return new VariationResource($this->findVariationByUser($user_id, $variation_id));
    }

    public function updateVariationByUser(string $user_id, $variation_id, $data): VariationResource
    {
        $variation = $this->findVariationByUser($user_id, $variation_id);
        $variation->update($data);
        return new VariationResource($variation);
    }

    public function deleteVariationByUser(string $user_id, $variation_id): int
    {
        return DB::table('variation')
            ->where('owner_id', $user_id)
            ->where('variation_id', $variation_id)
            ->delete();
    }

    public function getProductVariation($provider_id, $product_id)
    {
        $product = $this->productRepository->findByProviderIdAndProductId($provider_id, $product_id);
        return ProductVariationResource::collection($product->variations);

    }

    public function addNewProductVariation($provider_id, $product_id, array $data)
    {
        $product = $this->productRepository->findByProviderIdAndProductId($provider_id, $product_id);
        $data['product_id'] = $product->product_id;
        $product_variation = ProductVariation::create($data);

        return new ProductVariationResource($product_variation);
    }

    private function findVariationByUser($user_id, $variation_id)
    {
        return Variation::where('owner_id', $user_id)
            ->where('variation_id', $variation_id)
            ->firstorfail();
    }

}
