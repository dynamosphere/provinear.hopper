<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProviderCategoryController extends Controller
{
    protected CategoryService $categoryService;

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    /**
     * Get all Categories created by provider
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return $this->categoryService->getCategoriesByUser($request->user());
    }

    /**
     * Create a new Category (Provider)
     */
    public function store(CategoryRequest $request): CategoryResource
    {
        $validated = $request->validated();

        return $this->categoryService->addNewCategory($validated, $request->user());
    }

    /**
     * Display a category record created by provider
     */
    public function show(Request $request, string $category_id): CategoryResource
    {
        return $this->categoryService->getCategoryByUserById($request->user(), $category_id);
    }

    /**
     * Updated a category record created by provider
     */
    public function update(CategoryRequest $request, string $id): CategoryResource
    {
        $validated = $request->validated();

        return $this->categoryService->updateCategoryByUser($request->user(), $id, $validated);
    }

    /**
     * Remove the category record created by provider
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        if ($this->categoryService->deleteCategoryByUser($request->user(), $id)) {
            $message = 'deletion successful';
        } else {
            $message =  'deletion failed';
        }
        return response()->json(
            [
                'message' => $message
            ]
        );

    }
}
