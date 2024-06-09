<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use App\Repositories\AdminUserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class AdminUserService
{
    private AdminUserRepository $adminUserRepository;

    /**
     * @param AdminUserRepository $adminUserRepository
     */
    public function __construct(AdminUserRepository $adminUserRepository)
    {
        $this->adminUserRepository = $adminUserRepository;
    }

    public function makeUserAdmin($user_id, $user)
    {
        return $this->adminUserRepository->new([
            'admin_id'  => $user_id,
            'added_by'  => $user->user_id
        ]);
    }

    public function getAllAdmin(): Collection
    {
        return $this->adminUserRepository->findAll();
    }

    public function getAdminById($admin_id)
    {
        return $this->adminUserRepository->findById($admin_id);
    }

    public function revokeAdminPrivilege($admin_id): int
    {
        return $this->adminUserRepository->delete($admin_id);
    }

    public function setProductApproval($product_id, $data, $user): true
    {
        $product = Product::findorfail($product_id);

        $product->approval_by = $user->user_id;
        $product->approval_status = $data['approval'];
        if ($data['approval_comment'])
            $product->approval_comment = $data['approval_comment'];
        $product->save();
        return true;
    }

    public function activateSystemUser($data, $contextUser): bool
    {
        $user = User::find('system');

        if ($user == null || !$user->is_active)
            return false;

        if (env('SYSTEM_USER_EMAIL') != $contextUser->email)
            return false;

        $user->update(['password' => Hash::make($data['password']), 'is_active' => true]);
        return true;
    }


}
