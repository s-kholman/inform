<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Watering;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;

class WateringPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if (isset($user->registration->activation) ? true : false){
            return $user->registration->activation;
        } else{
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Watering $watering): bool
    {
        return true;
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
    public function update(User $user, Watering $watering): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Watering $watering): bool
    {
        $createdMinutes = Carbon::now()->diffInMinutes($watering->created_at);
        if (($createdMinutes <= 60 && $user->Registration->filial_id == $watering->filial_id) || ($user->email == 'sergey@krimm.ru')){
            return true;
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
