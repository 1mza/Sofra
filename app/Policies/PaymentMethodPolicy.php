<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentMethodPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list payment methods');
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view payment method');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create payment method');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update payment method');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete payment method');
    }


}