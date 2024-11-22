<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

class CreateAccessVpnWindowsTen extends IkevVpnFactory
{

    function run(): IkeVpnMikrotikInterface
    {
        return new CreateAccessVpnWindowsTenFactory();
    }
}
