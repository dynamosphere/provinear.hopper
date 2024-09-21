<?php

namespace App\Http\Controllers;

use App\Http\Requests\VariationRequest;
use App\Http\Resources\VariationResource;
use App\Services\VariationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class VariationController extends Controller
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
     * Display a listing of available Variation of Products
     */
    public function index(): AnonymousResourceCollection
    {
        return $this->variationService->listVariations();
    }

    /**
     * Add a new Product Variation
     */
    public function store(VariationRequest $request): VariationResource
    {
        $validated = $request->validated();
        return $this->variationService->addVariation($validated, $request->user());
    }

    /**
     * Display the specified Product Variation
     */
    public function show(string $id): VariationResource
    {
        return $this->variationService->getVariationById($id);
    }

    /**
     * Update the specified Product Variation
     */
    public function update(VariationRequest $request, string $id): VariationResource
    {
        $validated = $request->validated();

        return $this->variationService->updateVariation($id, $validated);
    }

    /**
     * Remove the specified Delete Product Variation
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        if ($this->variationService->removeVariation($id))
            return response()->json(['message' => 'Product Variation deleted successfully']);
        return response(status: ResponseAlias::HTTP_NOT_FOUND)->json(['message' => 'Deletion failed']);
    }
}
