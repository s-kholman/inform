<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;


interface IkeVpnMikrotikInterface
{
    public function action(MikrotikController $mikrotikController, IkeReport $report);
    public function fileDownload(MikrotikController $mikrotikController): void;
    public function archive(MikrotikController $mikrotikController, IkeReport $report): void;
    public function emailSend(UserVPN $user, MikrotikController $mikrotikController): void;

}
