<?php

namespace App\Http\Controllers;

use App\Http\Requests\VpnInfoRequest;
use App\Models\Registration;
use App\Models\VpnInfo;
use Illuminate\Support\Facades\Auth;

class VpnInfoController extends Controller
{
    public function index()
    {
        $info = Registration::query()
            ->with('vpninfo')
            ->where('user_id', Auth::user()->id)
            ->first();

        return view('cabinet.vpn.index', ['info' => $info]);
    }

    public function store(VpnInfoRequest $request)
    {
        VpnInfo::query()
            ->updateOrCreate(
                [
                    'registration_id' => $request['id'],
                ],
                [
                    'ip_domain' => $request['ip_domain'],
                    'login_domain' => $request['login_domain'],
                    'mail_send' => $request['mail_send'],
                ]
            );
        return redirect('/profile/show/'.$request->id);
    }
}
