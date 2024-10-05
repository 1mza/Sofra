<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list orders');
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view order');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete order');
    }


}