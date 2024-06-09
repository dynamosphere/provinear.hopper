<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait HasCrudActions
{
    /**
     * Get all instances of the model.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model::all();
    }

    /**
     * Find a model by its primary key.
     *
     * @param  int  $id
     * @return Model|null
     */
    public function findById(string $id): ?Model
    {
        return $this->model::find($id);
    }

    /**
     * Create a new model instance.
     *
     * @param  array  $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model::create($attributes);
    }

    /**
     * Update an existing model instance.
     *
     * @param  int    $id
     * @param  array  $attributes
     * @return bool
     */
    public function update(string $id, array $attributes): bool
    {
        $model = $this->model::find($id);
        if ($model) {
            return $model->update($attributes);
        }
        return false;
    }

    /**
     * Delete a model instance.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        $model = $this->model::find($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }

    /**
     * Send paginated instance of the model.
     *
     * @param  int  $perPage
     * @return Collection
     */
    public function paginate(int $perPage = 15)
    {
        return $this->model::paginate($perPage);
    }

    /**
     * Find an instance by columns.
     *
     * @param  string  $column
     * @param  string  $value
     * 
     * @return Model|null
     */
    public function findByColumn(string $column, $value)
    {
        return $this->model::where($column, $value)->first();
    }

    /**
     * Insert a new instance of the model.
     *
     * @param  array  $data
     * 
     * @return Model|null
     */
    public function insert(array $data)
    {
        return $this->model::insert($data);
    }

    /**
     * Find and update an instance.
     *
     * @param  string  $column
     * @param  string  $value
     * @param  array  $attributes
     * 
     * @return bool
     */
    public function updateByColumn(string $column, $value, array $attributes)
    {
        return $this->model::where($column, $value)->update($attributes);
    }

    /**
     * Find and delete an instance.
     *
     * @param  string  $column
     * @param  string  $value
     * 
     * @return bool
     */
    public function deleteByColumn(string $column, $value)
    {
        return $this->model::where($column, $value)->delete();
    }

   /**
     * Count how many instance exist for the model.
     *
     * @return int
     */ 
    public function count()
    {
        return $this->model::count();
    }

    /**
     * Get an instance along with its relationships.
     *
     * @param  array  $relationships
     * 
     * @return Collection
     */
    public function withRelationships(array $relationships)
    {
        return $this->model::with($relationships)->get();
    }

    /**
     * Search for an instance of a model
     *
     * @param  array  $columns
     * @param  string $searchTerm
     * 
     * @return Collection
     */
    public function search(array $columns, string $searchTerm)
    {
        $query = $this->model::query();
        foreach ($columns as $column) {
            $query->orWhere($column, 'LIKE', "%{$searchTerm}%");
        }
        return $query->get();
    }
}
