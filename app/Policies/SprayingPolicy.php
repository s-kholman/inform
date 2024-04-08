<?php

namespace App\Policies;

use App\Actions\registration\RegistrationCheckAction;
use App\Models\Spraying;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;

class SprayingPolicy
{
    private  RegistrationCheckAction $registrationCheckAction;

    public function __construct()
    {
        $this->registrationCheckAction = new RegistrationCheckAction;
    }

    public function myView (User $user): bool
    {
        return $user->email == 'sergey@krimm.ru';
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
    public function view(User $user, Spraying $spraying): bool
    {
        return false;
    }

    /**
     * Determine whether the user can сreateDeviceAction models.
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
        $createdMinutes = Carbon::now()->diffInMinutes($spraying->created_at);
        if (($createdMinutes <= 60 && $user->Registration->filial_id == $spraying->pole->filial_id) || ($user->email == 'sergey@krimm.ru')){
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
