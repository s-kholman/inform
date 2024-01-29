<?php

namespace App\Http\Controllers\SMS\PhoneAuth;

use App\Models\PhoneLimit;
use App\Models\Registration;
use Illuminate\Support\Str;

class PhoneAuth
{
    public function phoneAuth($phone): bool
    {
        if (Registration::where('phone', $phone)->where('activation', true)->count() ||
            PhoneLimit::where('phone', Str::after($phone, '+'))->where('active', true)->count()){

            return true;

        } else {

            return false;

        }
    }

}
