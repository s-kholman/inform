<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

class SslRevoke extends IkevVpnFactory
{

    function run(): IkeVpnMikrotikInterface
    {
        return new SslRevokeFactory();
    }
}
