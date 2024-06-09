<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function addNewCategory(array $data, $user): CategoryResource
    {
        if ($user != null) {
            $data['owner_id'] = $user->user_id;
        }

        return new CategoryResource($this->categoryRepository->new($data));
    }

    public function getCategories(string $perPage): AnonymousResourceCollection
    {
        return  CategoryResource::collection($this->categoryRepository->findAll($perPage));
    }

    public function getCategoriesByUser($user): AnonymousResourceCollection
    {
        return CategoryResource::collection($user->categories);
    }

    public function getCategoryById(String $category_id): CategoryResource
    {
        return new CategoryResource($this->categoryRepository->findById($category_id));
    }

    public function getCategoryByUserById($user, $category_id): CategoryResource
    {
        return new CategoryResource($user->categories()->where('category_id', $category_id)->first());
    }

    public function updateCategory(string $category_id, array $data): CategoryResource
    {
        return new CategoryResource($this->categoryRepository->update($category_id, $data));
    }

    public function updateCategoryByUser($user, string $category_id, array $data): CategoryResource
    {
        $category = $user->categories()->where('category_id', $category_id)->first();
        $category->update($data);
        return new CategoryResource($category);
    }

    public function deleteCategory(string $category_id): int
    {
        return $this->categoryRepository->delete($category_id);
    }

    public function deleteCategoryByUser($user, string $category_id)
    {
        return $user->categories()->where('category_id', $category_id)->delete();
    }

}
