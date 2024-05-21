<?php

namespace App\Policies;

use App\Actions\registration\RegistrationCheckAction;
use App\Models\SowingControlPotato;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;

class SowingControlPotatoPolicy
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
    public function view(User $user, SowingControlPotato $sowingControlPotato): bool
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
    public function update(User $user, SowingControlPotato $sowingControlPotato): bool
    {
        //return true;
        $createdMinutes = Carbon::now()->diffInMinutes($sowingControlPotato->created_at);

        if (($createdMinutes <= 60*24*7 && ($user->Registration->filial_id == $sowingControlPotato->filial_id || $user->Registration->post_id == 2)) || ($user->email == 'sergey@krimm.ru')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SowingControlPotato $sowingControlPotato): bool
    {
        $createdMinutes = Carbon::now()->diffInMinutes($sowingControlPotato->created_at);
        if (($createdMinutes <= 60*24*7 && $user->Registration->filial_id == $sowingControlPotato->filial_id) || ($user->email == 'sergey@krimm.ru')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SowingControlPotato $sowingControlPotato): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SowingControlPotato $sowingControlPotato): bool
    {
        return true;
    }

    public function edit(User $user, SowingControlPotato $sowingControlPotato): bool
    {
        if (($user->Registration->filial_id == $sowingControlPotato->filial_id || $user->Registration->post_id == 2) || ($user->email == 'sergey@krimm.ru')){
            return true;
        }
        return false;
    }
}
