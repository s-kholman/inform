<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

class CreateAccessVpnWindowsTenFactory implements IkeVpnMikrotikInterface
{

    /**
     * @throws \Exception
     */
    public function action(MikrotikController $mikrotikController, IkeReport $report)
    {

        $mikrotikController->sslGetActive()->sslCheckInvalidAfter()->sslCreate()->sslSing();

        if ($mikrotikController->sing)
        {
            throw new ExceptionInform('SSL sign');
        }
        //Удаляем все настройки
        $mikrotikController->modeConfigGet()->identityGet()->identityRemove()->modeConfigRemove();

        //Запрос / корректировка / создание
        $mikrotikController->modeConfigGet()->checkIpModeConfig()->modeConfigAddDynamicIP();

        //Запрос / корректировка / создание
        $mikrotikController->identityGet()->identitySet()->identityAdd();

        //экспорт SSL
        $mikrotikController->exportSSL();

        $script = new ScriptWindowsTenFactory();
        $script->action($mikrotikController, $report);
    }

    public function fileDownload(MikrotikController $mikrotikController): void
    {
        DownloadSSLMikrotik::download( $mikrotikController);
    }

    /**
     * @throws \Exception
     */
    public function archive(MikrotikController $mikrotikController, IkeReport $report): void
    {
        $archive = new Archive();
        $archive(['script_'.$mikrotikController->sslActive[0]['name'].'.ps1', 'ssl_'.$mikrotikController->sslActive[0]['name'].'.p12'],
            $mikrotikController->sslActive[0]['name'], $report);
    }

    public function emailSend(UserVPN $user, MikrotikController $mikrotikController): void
    {
        $email = new EmailSend();
        $email($user, $mikrotikController);
    }
}
