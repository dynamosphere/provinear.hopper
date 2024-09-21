<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Services\VariationService;
use Illuminate\Http\Request;

class ProviderProductVariationController extends Controller
{
    private VariationService $variationService;

    /**
     * @param VariationService $variationService
     */
    public function __construct(VariationService $variationService)
    {
        $this->variationService = $variationService;
    }

    /**
     * Get all variations of a product
     */
    public function index(Request $request, $product)
    {
        return $this->variationService->getProductVariation($request->user()->provider->provider_id, $product);
    }

    /**
     * Add a variation to a product
     */
    public function store(Request $request, $product)
    {
        //
    }

    /**
     * Retrieve a Product Variation
     */
    public function show(Request $request, string $variation)
    {
        //
    }

    /**
     * Update a Product Variation
     */
    public function update(Request $request, string $variation)
    {
        //
    }

    /**
     * Remove a product variation
     */
    public function destroy(Request $request, string $variation)
    {
        //
    }
}
