<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

use App\Actions\VPN\SSLInfo;

class CreateAccessVpnWindowsTen extends IkevVpnFactory
{

    function run(): IkeVpnMikrotikInterface
    {
        $class_ssl_info = new SSLInfo();

        $sslInfo = $class_ssl_info($this->user);

        if (!empty($sslInfo) && $sslInfo['expires_after'] <= 30){
            $this->mikrotikController->sslGetActive();
            $this->mikrotikController->sslRevoke();
        }

        return new CreateAccessVpnWindowsTenFactory();
    }
}
