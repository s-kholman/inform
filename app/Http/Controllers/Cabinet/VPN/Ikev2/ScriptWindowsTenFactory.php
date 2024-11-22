<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;


use App\Actions\TempDir\TempDir;
use PHPUnit\Util\Exception;

class ScriptWindowsTenFactory implements IkeVpnMikrotikInterface
{
    use TempDir;

    /**
     * @throws \Exception
     */
    public function action(MikrotikController $mikrotikController, IkeReport $report)
    {
        $mikrotikController->sslGetActive()->modeConfigGet();
        if ($mikrotikController->modeConfig <> ''){
            $data = sprintf(
                'Set-ExecutionPolicy -Scope CurrentUser RemoteSigned'.PHP_EOL.
                'if (-NOT ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole(`'.PHP_EOL.
                '[Security.Principal.WindowsBuiltInRole] "Administrator")) {'.PHP_EOL.
                'Start-Process powershell.exe -Verb RunAs -ArgumentList (\'-noprofile -noexit -file "{0}" -elevated\' -f ( $myinvocation.MyCommand.Definition ))'.PHP_EOL.
                'Break}'.PHP_EOL.
                'Get-VpnConnection | Where-Object { $_.Name -eq \'VPN-KRiMM\'} | Remove-VpnConnection -Name "VPN-KRiMM" -Force'.PHP_EOL.
                'Add-VpnConnection -Name "VPN-KRiMM" -ServerAddress "welcome.krimm.ru" -TunnelType Ikev2 -AuthenticationMethod MachineCertificate -SplitTunneling'.PHP_EOL.
                'Add-VpnConnectionRoute -ConnectionName "VPN-KRiMM" -DestinationPrefix %s/32'.PHP_EOL.
                '$DesktopPath = [Environment]::GetFolderPath("Desktop")'.PHP_EOL.
                '$OFS = "`r`n"'.PHP_EOL.
                '$msg = "username:s:krimm\%s" + $OFS + "full address:s:%s"'.PHP_EOL.
                'New-Item -Path $DesktopPath -Name "KRiMM.rdp" -ItemType "file" -Value $msg -Force'.PHP_EOL.
                'Get-ChildItem -Path Cert:\LocalMachine\My | Where-Object { $_.FriendlyName -eq \'%s\' } | Remove-Item'

                , $mikrotikController->user->ip_domain(), $mikrotikController->user->login_domain(), $mikrotikController->user->ip_domain(), $mikrotikController->user->revoke_friendly_name());
            try {
                file_put_contents($this->pathGet(). 'script_'.$mikrotikController->sslActive[0]['name'].'.ps1', $data);
            }catch (Exception $exception){
                throw new \Exception($exception->getMessage());
            }
            $report->set('message', 'Скрипт сгенерирован');
        } else {
            $report->set('message', 'Настройка отсутствует и/или не соответствует Windows 10');
        }

    }

    public function emailSend(UserVPN $user, MikrotikController $mikrotikController): void
    {
        $email = new EmailSend();
        $email($user, $mikrotikController);
    }

    public function fileDownload(MikrotikController $mikrotikController): void
    {
        // TODO: Implement fileDownload() method.
    }

    /**
     * @throws \Exception
     */
    public function archive(MikrotikController $mikrotikController, IkeReport $report): void
    {
        $archive = new Archive();
        $archive(['script_'.$mikrotikController->sslActive[0]['name'].'.ps1'],
            $mikrotikController->sslActive[0]['name'], $report);
    }
}
