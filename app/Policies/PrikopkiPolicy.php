<?php

namespace App\Policies;

use App\Models\Prikopki;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class PrikopkiPolicy
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
        return $user->can('Prikopki.user.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->can('Prikopki.user.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Prikopki.completed.create');
    }

    /**
     * Determine whether the user can store models.
     */
    public function store(User $user): bool
    {
        return $user->can('Prikopki.completed.store');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Prikopki $prikopki): bool
    {
        return $user->can('Prikopki.completed.store');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(User $user, Prikopki $prikopki): bool
    {

        $createdMinutes = Carbon::now()->diffInMinutes($prikopki->created_at);

        if (($createdMinutes <= 60 && $user->Registration->filial_id == $prikopki->filial_id) || ($user->can('super-user.moonlighter'))){
            return $user->can('Prikopki.completed.delete');
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
