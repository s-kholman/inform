<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;


use App\Actions\TempDir\TempDir;
use PHPUnit\Util\Exception;

class ScriptWindowsSevenFactory implements IkeVpnMikrotikInterface
{
    use TempDir;

    /**
     * @throws \Exception
     */
    public function action(MikrotikController $mikrotikController, IkeReport $report)
    {
        $mikrotikController->sslGetActive()->modeConfigGet();
        if ($mikrotikController->getAddressStatic() <> ''){
            $data = sprintf('route /p add %s mask 255.255.255.255 %s',
                $mikrotikController->user->ip_domain(),
                $mikrotikController->getAddressStatic());
            try {
                file_put_contents($this->pathGet(). 'script_'.$mikrotikController->sslActive[0]['name'].'.cmd', $data);
            }catch (Exception $exception){
                throw new \Exception($exception->getMessage());
            }
            $report->set('message', 'Скрипт сгенерирован');
        } else {
            throw new \Exception('Настройка modeConfig не соответствует Windows 7');
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
        $archive(['script_'.$mikrotikController->sslActive[0]['name'].'.cmd'],
            $mikrotikController->sslActive[0]['name'], $report);
    }
}
