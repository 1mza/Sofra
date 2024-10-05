<?php

namespace App\Policies;

use App\Models\User;
use App\Models\City;
use App\Models\Neighbourhood;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list locations');
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view location');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create location');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update location');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete location');
    }


}