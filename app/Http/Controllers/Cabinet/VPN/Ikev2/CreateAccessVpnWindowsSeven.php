<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

class CreateAccessVpnWindowsSeven extends IkevVpnFactory
{

    function run(): IkeVpnMikrotikInterface
    {
        return new CreateAccessVpnWindowsSevenFactory();
    }
}
