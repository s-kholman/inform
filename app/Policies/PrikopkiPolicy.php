<?php

namespace App\Policies;

use App\Actions\registration\RegistrationCheckAction;
use App\Models\Prikopki;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;

class PrikopkiPolicy
{

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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Prikopki $prikopki): bool
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
    public function update(User $user, Prikopki $prikopki): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Prikopki $prikopki): bool
    {
        $createdMinutes = Carbon::now()->diffInMinutes($prikopki->created_at);
        if (($createdMinutes <= 60 && $user->Registration->filial_id == $prikopki->filial_id) || ($user->email == 'sergey@krimm.ru')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Prikopki $prikopki): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Prikopki $prikopki): bool
    {
        return false;
    }
}
