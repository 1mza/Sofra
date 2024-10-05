<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list permissions');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create permission');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update permission');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete permission');
    }


}