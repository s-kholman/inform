<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\Profile;

class RoleUserController extends Controller
{
    public function userRoleAdd(Registration $registration, Request $request)
    {
        $registration->user->assignRole($request->role);
        return redirect('/profile/show/'.$registration->id);
    }

    public function userRoleDestroy(Registration $registration, Request $request)
    {
        $registration->user->removeRole($request->role);
        return redirect('/profile/show/'.$registration->id);
    }
}
