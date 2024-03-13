<?php

namespace App\Policies;

use App\Enums\UserRoles;
use App\Models\Travel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TravelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Travel $travel): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole([UserRoles::Admin->value, UserRoles::Editor->value]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Travel $travel): bool
    {
        return $user->hasAnyRole([UserRoles::Admin->value, UserRoles::Editor->value]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Travel $travel): bool
    {
        return $user->hasAnyRole([UserRoles::Admin->value]);
    }
}
