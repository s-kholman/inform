<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

class SettingsDestroyFactory implements IkeVpnMikrotikInterface
{

    public function action(MikrotikController $mikrotikController, IkeReport $report)
    {
        $mikrotikController->modeConfigGet()->identityGet()->identityRemove()->modeConfigRemove();
        $report->set('message', 'Настройки удалены');
    }

    public function fileDownload(MikrotikController $mikrotikController): void
    {
        // TODO: Implement fileDownload() method.
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
