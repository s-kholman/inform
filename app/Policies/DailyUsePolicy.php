<?php

namespace App\Policies;

use App\Models\DailyUse;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DailyUsePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return 'sergey@krimm.ru' == $user->email;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DailyUse $dailyUse): bool
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
    public function update(User $user, DailyUse $dailyUse): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DailyUse $dailyUse): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DailyUse $dailyUse): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DailyUse $dailyUse): bool
    {
        return true;
    }
}
