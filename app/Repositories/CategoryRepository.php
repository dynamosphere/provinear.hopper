<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements IRepository
{
    protected Category $category;

    /**
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function findById(String $id): Category
    {
        return Category::findOrFail($id);
    }

    public function findAll(int $perPage = 15)
    {
        return Category::paginate($perPage);
    }

    public function save(Category $category): bool
    {
        return $category->save();
    }

    public function new(array $data) {
        return Category::create($data);
    }


    public function update($id, $data)
    {
        $user = $this->findById($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        return Category::destroy($id);
    }
}
