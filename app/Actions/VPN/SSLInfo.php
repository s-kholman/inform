<?php

namespace App\Actions\VPN;

use App\Http\Controllers\Cabinet\VPN\Ikev2\MikrotikController;
use App\Http\Controllers\Cabinet\VPN\Ikev2\UserVPN;
use App\Models\User;
use Illuminate\Support\Carbon;

class SSLInfo
{
    public function __invoke(User $user) : array
    {
        $ssl_info = [];

        $userVPN = new UserVPN($user);

        $ssl = new MikrotikController($userVPN);

        if (array_key_exists(0, $ssl->sslGetActive()->sslActive)){
            $r = (str_replace(['w', 'd', 'h', 'm', 's'], [' week ', ' day ', ' hour ', ' min ', ' second '], $ssl->sslGetActive()->sslActive[0]['expires-after']));
            $ssl_info ['expire'] = Carbon::parse($r, 'Asia/Yekaterinburg')->format('d.m.Y H:i:s');
            $ssl_info ['expires_after'] = Carbon::now('Asia/Yekaterinburg')->diffInDays(Carbon::parse($r));
        }

        return $ssl_info;
    }
}
