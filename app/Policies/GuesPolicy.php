<?php

namespace App\Policies;

use App\Actions\registration\RegistrationCheckAction;
use App\Models\Gues;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;

class GuesPolicy
{
    private  RegistrationCheckAction $registrationCheckAction;

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
    public function view(User $user, Gues $gues): bool
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
    public function update(User $user, Gues $gues): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Gues $gues): bool
    {
        $createdMinutes = Carbon::now()->diffInMinutes($gues->created_at);
        if (($createdMinutes <= 60 && $user->Registration->activation ?? false) || ($user->email == 'sergey@krimm.ru')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Gues $gues): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Gues $gues): bool
    {
        return false;
    }
}
