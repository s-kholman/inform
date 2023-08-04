<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegistrationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function noRegistration()
    {
        return User::with('Registration')->findOrFail(Auth::user()->id);
    }
}
