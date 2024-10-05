<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingTextPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list setting texts');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create setting text');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update setting text');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete setting text');
    }


}