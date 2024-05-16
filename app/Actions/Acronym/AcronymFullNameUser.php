<?php

namespace App\Actions\Acronym;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Support\Str;

class AcronymFullNameUser
{
    public function Acronym(Registration $registration)
    {
        return $registration->last_name . ' '. mb_substr($registration->first_name, 0, 1) . mb_substr($registration->middle_name, 0, 1);
    }
}
