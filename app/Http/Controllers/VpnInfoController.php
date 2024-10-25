<?php

namespace App\Http\Controllers;

use App\Models\VpnInfo;
use Illuminate\Http\Request;

class VpnInfoController extends Controller
{
    public function index()
    {
        return view('cabinet.vpn.index');
    }

    public function store(Request $request)
    {
        VpnInfo::query()
            ->updateOrCreate(
                [
                    'registration_id' => $request->id,
                ],
                [
                    'ip_domain' => $request->ip_domain,
                    'login_domain' => $request->login_domain,
                ]
            );
        return redirect('/profile/show/'.$request->id);
    }
}
