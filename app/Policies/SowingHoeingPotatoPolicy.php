<?php

namespace App\Policies;

use App\Models\SowingHoeingPotato;
use App\Models\User;
use Carbon\Carbon;

class SowingHoeingPotatoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('SowingHoeingPotato.user.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SowingHoeingPotato $sowingHoeingPotato): bool
    {
        return $user->can('SowingHoeingPotato.user.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('SowingHoeingPotato.completed.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SowingHoeingPotato $sowingHoeingPotato): bool
    {

        $createdMinutes = Carbon::now()->diffInMinutes($sowingHoeingPotato->created_at);
        if ((
            $createdMinutes <= 60*24*7
            && ($user->Registration->filial_id == $sowingHoeingPotato->filial_id || $user->can('SowingHoeingPotato.deploy.store')))
            ){
            return true;
        }
        return false;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SowingHoeingPotato $sowingHoeingPotato): bool
    {
        $createdMinutes = Carbon::now()->diffInMinutes($sowingHoeingPotato->created_at);

        if (($createdMinutes <= 60*24*7 && $user->Registration->filial_id == $sowingHoeingPotato->filial_id) && $user->can('SowingHoeingPotato.completed.delete')){
            return true;
        }
        return false;

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SowingHoeingPotato $sowingHoeingPotato): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SowingHoeingPotato $sowingHoeingPotato): bool
    {
        return false;
    }
}
