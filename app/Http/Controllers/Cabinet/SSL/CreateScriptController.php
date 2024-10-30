<?php

namespace App\Http\Controllers\cabinet\ssl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateScriptController extends Controller
{
    use TempDir;

    static function create($user, $fileName, $ipConfigW7, $pathTemp)
    {
        if ($user['settings']->W7){
            $data = sprintf('route /p add %s mask 255.255.255.255 %s',$user['ip_domain'], $ipConfigW7
            );
        } else {
            $data = sprintf(
                'Set-ExecutionPolicy -Scope CurrentUser RemoteSigned'.PHP_EOL.
                'if (-NOT ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole(`'.PHP_EOL.
                '[Security.Principal.WindowsBuiltInRole] "Administrator")) {'.PHP_EOL.
                'Start-Process powershell.exe -Verb RunAs -ArgumentList (\'-noprofile -noexit -file "{0}" -elevated\' -f ( $myinvocation.MyCommand.Definition ))'.PHP_EOL.
                'Break}'.PHP_EOL.
                'Get-VpnConnection | Where-Object { $_.Name -eq \'VPN-KRiMM\'} | Remove-VpnConnection -Name "VPN-KRiMM" -Force'.PHP_EOL.
                'Add-VpnConnection -Name "VPN-KRiMM" -ServerAddress "welcome.krimm.ru" -TunnelType Ikev2 -AuthenticationMethod MachineCertificate -SplitTunneling -PassThru'.PHP_EOL.
                'Add-VpnConnectionRoute -ConnectionName "VPN-KRiMM" -DestinationPrefix %s/32 –PassThru'.PHP_EOL.
                '$DesktopPath = [Environment]::GetFolderPath("Desktop")'.PHP_EOL.
                '$OFS = "`r`n"'.PHP_EOL.
                '$msg = "username:s:krimm\%s" + $OFS + "full address:s:%s"'.PHP_EOL.
                'New-Item -Path $DesktopPath -Name "KRiMM.rdp" -ItemType "file" -Value $msg -Force'.PHP_EOL.
                'Get-ChildItem -Path Cert:\LocalMachine\My | Where-Object { $_.FriendlyName -eq \'%s\' } | Remove-Item'

                , $user['ip_domain'], $user['login_domain'], $user['ip_domain'], $user['revoke_friendly_name']);
        }


        file_put_contents($pathTemp . $fileName, $data);
    }
}
