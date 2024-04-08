<?php

namespace App\Policies;

use App\Actions\registration\RegistrationCheckAction;
use App\Models\User;

class SowingPolicy
{

    private  RegistrationCheckAction $registrationCheckAction;

    public function __construct()
    {
        $this->registrationCheckAction = new RegistrationCheckAction;
    }
    /**
     * Create a new policy instance.
     */

    public function create(User $user): bool
    {
        return $this->registrationCheckAction->check($user);
    }

    public function viewAdmin(User $user)
    {
        return $user->email == 'sergey@krimm.ru' ? true : false;
    }
}
