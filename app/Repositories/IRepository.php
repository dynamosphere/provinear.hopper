<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function findById(String $id);

    public function findAll();

    public function new(array $data);

    public function update($id, $data);

    public function delete($id);
}
