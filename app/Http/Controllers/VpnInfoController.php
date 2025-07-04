<?php

namespace App\Http\Controllers;

use App\Actions\VPN\SSLInfo;
use App\Http\Controllers\Application\ApplicationGetActive;
use App\Http\Requests\VpnInfoRequest;
use App\Models\Application\Application;
use App\Models\Application\ApplicationStatus;
use App\Models\Registration;
use App\Models\VpnInfo;
use Illuminate\Support\Facades\Auth;

class VpnInfoController extends Controller
{
    public function index(SSLInfo $SSLInfo)
    {
        $info = Registration::query()
            ->with('vpninfo')
            ->where('user_id', Auth::user()->id)
            ->first();

        $applications = new ApplicationGetActive();

        return view('cabinet.vpn.index',
            [
                'info' => $info,
                'ssl_info' => $SSLInfo(Auth::user()),
                'application' => $applications(Auth::user()->id, 'IKEv2AccessRequestType'),

            ]);

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
