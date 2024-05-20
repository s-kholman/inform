<?php

namespace App\Policies;

use App\Actions\registration\RegistrationCheckAction;
use App\Models\Sevooborot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;

class SevooborotPolicy
{
    public function __construct()
    {
        $this->registrationCheckAction = new RegistrationCheckAction;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->registrationCheckAction->check($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Sevooborot $sevooborot): bool
    {
        return $this->registrationCheckAction->check($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->registrationCheckAction->check($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Sevooborot $sevooborot): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Sevooborot $sevooborot): bool
    {
        $createdMinutes = Carbon::now()->diffInMinutes($sevooborot->created_at);
        if (($createdMinutes <= 60 && $user->Registration->filial_id == $sevooborot->Pole->filial_id) || ($user->email == 'sergey@krimm.ru')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Sevooborot $sevooborot): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Sevooborot $sevooborot): bool
    {
        return true;
    }
}
