<?php

namespace App\Policies;

use App\Models\SalesPage;
use App\Models\User;

class SalesPagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SalesPage $salesPage): bool
    {
        return $user->id === $salesPage->user_id;
    }

    public function update(User $user, SalesPage $salesPage): bool
    {
        return $user->id === $salesPage->user_id;
    }

    public function delete(User $user, SalesPage $salesPage): bool
    {
        return $user->id === $salesPage->user_id;
    }
}
