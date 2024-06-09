<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PublicCategoryController extends Controller
{
    private CategoryService $categoryService;

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPageParam = $request->query('per_page');
        $perPage = is_numeric($perPageParam) ? intval($perPageParam) : 15;
        return $this->categoryService->getCategories($perPage);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): CategoryResource
    {
        return $this->categoryService->getCategoryById($id);
    }
}
