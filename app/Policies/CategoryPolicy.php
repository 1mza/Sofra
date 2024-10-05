<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list categories');
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view category');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create category');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update category');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete category');
    }


}