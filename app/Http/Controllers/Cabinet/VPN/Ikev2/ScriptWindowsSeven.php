<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

class ScriptWindowsSeven extends IkevVpnFactory
{
    function run(): IkeVpnMikrotikInterface
    {
        return new ScriptWindowsSevenFactory();
    }
}
