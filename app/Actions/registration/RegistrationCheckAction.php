<?php

namespace App\Actions\registration;

use App\Models\User;

class RegistrationCheckAction
{
    public function check(User $user):bool
    {
        if ($user->registration->activation ?? false){
            return $user->registration->activation;
        } else{
            return false;
        }
    }
}
