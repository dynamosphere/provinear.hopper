<?php

namespace App\Repositories;

use App\Models\Admin;

class AdminUserRepository implements IRepository
{

    public function findById(string $id)
    {
        return Admin::findorfail($id);
    }

    public function findAll()
    {
        return Admin::all();
    }

    public function new(array $data)
    {
        return Admin::create($data);
    }

    public function update($id, $data)
    {
        $adminUser = $this->findById($id);
        $adminUser->update($data);
        return $adminUser;
    }

    public function delete($id)
    {
        return Admin::destroy($id);
    }
}
