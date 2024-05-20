<?php

namespace App\Policies;

use App\Models\Shop;
use App\Models\User;
use App\Policies\AbstractOwnerPolicy;
use Illuminate\Database\Eloquent\Model;

class ShopPolicy extends AbstractOwnerPolicy
{

    protected function getModelType(): string
    {
        return Shop::class;
    }

    public function view(User $user, Model $shop)
    {
        $shop->user = $shop->provider->user;
        return parent::view($user, $shop);
    }

    public function update(User $user, Model $shop)
    {
        $shop->user = $shop->provider->user;
        return parent::view($user, $shop);
    }

    public function delete(User $user, Model $shop)
    {
        $shop->user = $shop->provider->user;
        return parent::view($user, $shop);
    }
}
