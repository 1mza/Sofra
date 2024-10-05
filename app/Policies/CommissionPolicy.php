<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list commissions');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create commission');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update commission');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete commission');
    }


}