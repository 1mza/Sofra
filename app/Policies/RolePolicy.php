<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list roles');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create role');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update role');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete role');
    }


}