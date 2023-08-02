<?php

namespace App\Policies;

use App\Models\Spraying;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SprayingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return isset($user->registration->activation) ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Spraying $spraying): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Spraying $spraying): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Spraying $spraying): bool
    {

        if ($user->Registration->filial_id == $spraying->pole->filial_id){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Spraying $spraying): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Spraying $spraying): bool
    {
        return true;
    }
}
