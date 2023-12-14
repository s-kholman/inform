<?php

namespace App\Policies;

use App\Models\User;

class SowingPolicy
{
    /**
     * Create a new policy instance.
     */

    public function create(User $user): bool
    {
        return isset($user->registration->activation) ? true : false;
    }
}
