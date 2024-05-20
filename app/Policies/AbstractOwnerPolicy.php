<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

abstract class AbstractOwnerPolicy
{
    abstract protected function getModelType(): string;

    protected function assertModelType(Model $model)
    {
        $modelType = $this->getModelType();
        assert($model instanceof $modelType, new InvalidArgumentException('Invalid model type.'));
    }

    public function view(User $user, Model $model)
    {
        $this->assertModelType($model);

        return $user->user_id === $model->user->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function delete(User $user, Model $model)
    {
        $this->assertModelType($model);

        return $user->user_id === $model->user->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function update(User $user, Model $model)
    {
        $this->assertModelType($model);

        return $user->user_id === $model->user->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

}
