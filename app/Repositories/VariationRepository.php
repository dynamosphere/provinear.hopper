<?php

namespace App\Repositories;

use App\Models\Variation;
use Illuminate\Database\Eloquent\Collection;

class VariationRepository implements IRepository
{

    public function findById(string $id)
    {
        return Variation::findorfail($id);
    }

    public function findAll(): Collection
    {
        return Variation::all();
    }

    public function new(array $data)
    {
        return Variation::create($data);
    }

    public function update($id, $data)
    {
        $variation = $this->findById($id);
        $variation->update($data);
        return $variation;
    }

    public function delete($id): int
    {
        return Variation::destroy($id);
    }
}
