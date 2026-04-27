<?php

namespace App\Policies;

use App\Actions\registration\RegistrationCheckAction;
use App\Models\User;
use App\Models\Watering;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;

class WateringPolicy
{

    public function myView (User $user): bool
    {
        return $user->can('super-user.moonlighter');
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Watering.user.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->can('Watering.user.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Watering.completed.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Watering $watering): bool
    {
        return $user->can('Watering.completed.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function store(User $user): bool
    {
        return $user->can('Watering.completed.store');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Watering $watering): bool
    {
        $createdMinutes = Carbon::now()->diffInMinutes($watering->created_at);

        if (($createdMinutes <= 60 && $user->Registration->filial_id == $watering->filial_id) || ($user->can('super-user.moonlighter'))){
            return $user->can('Watering.completed.delete');
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Watering $watering): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Watering $watering): bool
    {
        return true;
    }
}
