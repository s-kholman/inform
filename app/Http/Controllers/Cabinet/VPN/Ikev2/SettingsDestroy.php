<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

class SettingsDestroy extends IkevVpnFactory
{

    function run(): IkeVpnMikrotikInterface
    {
        return new SettingsDestroyFactory();
    }
}
