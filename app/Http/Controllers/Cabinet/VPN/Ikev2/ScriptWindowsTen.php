<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

class ScriptWindowsTen extends IkevVpnFactory
{
    function run(): IkeVpnMikrotikInterface
    {
        return new ScriptWindowsTenFactory();
    }
}
