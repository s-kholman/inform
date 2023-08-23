<?php

namespace App\Policies;

use App\Models\Take;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class TakePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->Registration->activation ?? false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Take $take): bool
    {
        return $user->Registration->activation ?? false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->Registration->activation ?? false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Take $take): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Take $take): bool
    {
            $createdMinutes = Carbon::now()->diffInMinutes($take->created_at);
            if ($createdMinutes <= 60 && $user->Registration->activation ?? false) {
                return true;
            } else {
                return false;
            }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Take $take): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Take $take): bool
    {
        return false;
    }
}
