<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list products');
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view product');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create product');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update product');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete product');
    }


}