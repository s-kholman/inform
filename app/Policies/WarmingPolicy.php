<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Warming;
use Illuminate\Auth\Access\Response;

class WarmingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Warming.user.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->can('Warming.user.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Warming.completed.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
         return $user->can('Warming.completed.store');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Warming $warming): bool
    {
        return $user->can('Warming.completed.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Warming $warming): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Warming $warming): bool
    {
        return false;
    }
}
