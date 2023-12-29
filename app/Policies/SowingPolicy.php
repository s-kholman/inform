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

    public function viewAdmin(User $user)
    {
        return $user->email == 'sergey@krimm.ru' ? true : false;
    }
}
