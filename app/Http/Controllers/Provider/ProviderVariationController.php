<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariationRequest;
use App\Http\Resources\VariationResource;
use App\Models\Variation;
use App\Services\VariationService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProviderVariationController extends Controller
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
     * Display a listing of all variation by a provider
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return $this->variationService->getVariationsByUser($request->user()->user_id);
    }

    /**
     * Add a new Product Variation
     */
    public function store(VariationRequest $request): VariationResource
    {
        return $this->variationService->addVariation($request->validated(), $request->user());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $variation): VariationResource
    {
        return $this->variationService->getVariationByUser($request->user()->user_id, $variation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VariationRequest $request, string $variation): VariationResource
    {
        return $this->variationService->updateVariationByUser($request->user()->user_id, $variation, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $variation)
    {
        $this->variationService->deleteVariationByUser($request->user()->user_id, $variation);
    }
}
