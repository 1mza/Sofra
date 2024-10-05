<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactLinkPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list contact links');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create contact link');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update contact link');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete contact link');
    }


}