<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

class SslRevokeFactory implements IkeVpnMikrotikInterface
{

    public function action(MikrotikController $mikrotikController, IkeReport $report)
    {
        $mikrotikController->sslGetActive();
        $report->set('message', 'Отозван сертификат ' . $mikrotikController->sslActive[0]['name']);
        $mikrotikController->sslRevoke();
    }

    public function fileDownload(MikrotikController $mikrotikController): void
    {

    }

    public function archive(MikrotikController $mikrotikController, IkeReport $report): void
    {
        // TODO: Implement archive() method.
    }

    public function emailSend(UserVPN $user, MikrotikController $mikrotikController): void
    {
        // TODO: Implement emailSend() method.
    }
}
