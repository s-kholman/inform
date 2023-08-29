<?php

namespace App\Policies;

use App\Models\Poliv;
use App\Models\Registration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;

class PolivPolicy
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
    public function view(User $user, Poliv $poliv): bool
    {
        return false;
    }

    /**
     * Determine whether the user can сreateDeviceAction models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Poliv $poliv): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Poliv $poliv): bool
    {
        $createdMinutes = Carbon::now()->diffInMinutes($poliv->created_at);
        if (($createdMinutes <= 60 && $user->Registration->filial_id == $poliv->filial_id) || ($user->email == 'sergey@krimm.ru')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Poliv $poliv): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Poliv $poliv): bool
    {
        return false;
    }
}
