<?php

namespace App\Http\Controllers\Cabinet\VPN\Schedule;

use App\Actions\VPN\SSLInfo;
use App\Jobs\ExpirationSSLJobs;
use App\Models\VpnInfo;

class ExpirationSSL
{
    public function __invoke()
    {
        $vpnUsers = VpnInfo::query()->with('Registration.User')->get();

        $check = $vpnUsers->filter(function ($var){
            $sslInfoClass = new SSLInfo();
            $sslInfo = $sslInfoClass($var->Registration->User);

            if (!empty($sslInfo) && ($sslInfo['expires_after'] == 30 || $sslInfo['expires_after'] == 15 || $sslInfo['expires_after'] == 3)){
                return true;
            }
             return false;
        });

        if ($check->isNotEmpty()){
            foreach ($check as $userExpiration){
                ExpirationSSLJobs::dispatch($userExpiration);
            }
        }
    }
}
