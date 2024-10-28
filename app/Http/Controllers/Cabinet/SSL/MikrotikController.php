<?php

namespace App\Http\Controllers\Cabinet\SSL;

use App\Actions\Acronym\AcronymFullNameUser;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SMS\Send\SmsSend;
use App\Jobs\SSLSign;
use App\Jobs\VPNFileClear;
use App\Jobs\VPNSendEmailAccess;
use App\Models\User;
use App\Models\VpnInfo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RouterOS\Client;
use RouterOS\Query;
use ZipArchive;


class MikrotikController extends Controller
{
    private Client $client;
    private array $user;
    private string $path_temp;

    public function __construct($userID)
    {
        $this->client = new Client(
            [
                'host' => env('MIKROTIK_HOST'),
                'user' => env('MIKROTIK_USERNAME'),
                'pass' => env('MIKROTIK_PASSWORD'),
                'port' => 8728
            ]
        );

        $this->path_temp = storage_path() . '/app/temp/';

        if (!file_exists($this->path_temp)) {
            mkdir($this->path_temp, 0777, true);
        }

        $user = User::query()
            ->with(['Registration','FilialName'])
            ->where('id', $userID)
            ->limit(1)
            ->get();

        $vpn = VpnInfo::query()->where('registration_id', $user[0]->Registration->id)->first();

        $this->user['locality'] = Str::slug(Str::lower($user[0]->FilialName->name),'_','ru');
        $this->user['common_name'] = Str::slug(
            Str::lower(Str::limit($user[0]->Registration->first_name, 1)).' '.
            Str::lower($user[0]->Registration->last_name).' '.
            $user[0]->id,'_','ru');

        if(empty($vpn->revoke_friendly_name)){
            $this->user['revoke_friendly_name'] = '';
        } else {
            $this->user['revoke_friendly_name'] = $vpn->revoke_friendly_name;
        }

        if(empty($vpn->ip_domain)){
            $this->user['ip_domain'] = '';
        } else {
            $this->user['ip_domain'] = $vpn->ip_domain;
        }

        if(empty($vpn->mail_send)){
            $this->user['email'] = $user[0]->email;
        } else {
            $this->user['email'] = $vpn->mail_send;
        }

        if(empty($vpn->login_domain)){
            $this->user['login_domain'] = '';
        } else {
            $this->user['login_domain'] = $vpn->login_domain;
        }

        $this->user['phone'] = $user[0]->Registration->phone;
        $this->user['registration_id'] = $user[0]->Registration->id;
        $fullNameUser = new AcronymFullNameUser();
        $this->user['full_name'] = $fullNameUser->Acronym($user[0]->Registration);


    }

    public function start()
    {
        if ($this->user['ip_domain'] == ''){
            return ['message' => 'Нет IP адреса пользователя'];
        }

        $getModeConfig = $this->client->query(
            (new Query('/ip/ipsec/mode-config/print'))
                ->where('name', $this->user['common_name']))
            ->read();

        if (array_key_exists(0,$getModeConfig)){
            $position = strpos($getModeConfig[0]['split-include'], '/');
            $result = substr($getModeConfig[0]['split-include'], 0, $position);
            if ($result != $this->user['ip_domain']){
                    $this->client->query(
                   (new Query ('/ip/ipsec/mode-config/set'))
                        ->equal('.id', $getModeConfig[0]['.id'])
                        ->equal('split-include', $this->user['ip_domain'])
                )
                    ->read();
            }
        }

        if (!array_key_exists(0, $getModeConfig)){
            $this->client->query(
                (new Query('/ip/ipsec/mode-config/add'))
                    ->equal('address-pool', 'POOL-IKEv2')
                    ->equal('address-prefix-length', '32')
                    ->equal('name', $this->user['common_name'])
                    ->equal('split-include', $this->user['ip_domain']))
                ->read();
        }

        /*
         *Проверяем если активный сертификаты пользователя
         * со сроком окончания менее или равному 30 дней
         * если условия подходят аннулируем его и переходим к выпуску нового
         * */
        $sslGet = $this->client->query(
            (new Query('/certificate/print'))
            ->where('issued', "true")
            ->where('common-name', $this->user['common_name'])
        )->read();

        if (!empty($sslGet)){
            $day = Carbon::parse(date('Y-m-d',strtotime(Str::replace('/', ' ', $sslGet[0]['invalid-after']))))->diffInDays(now());
            if ($day <= 30){
                $revoke = (new Query('/certificate/issued-revoke'))
                    ->equal('.id', $sslGet[0]['.id']);
                $this->client->query($revoke)->read();
                VpnInfo::query()->update([
                    'registration_id' => $this->user['registration_id'],
                    'revoke_friendly_name' => $sslGet[0]['name']
                ]);
            } else {
                $this->exportSSL($sslGet[0]['.id']);
                $this->identityCreate($sslGet[0]['name']);
                $this->createPowerShell($this->path_temp . $sslGet[0]['name']);
                $this->downloadMikrotikToStorage($sslGet[0]['name']);
                $this->arhiveAdd($sslGet[0]['name']);
                $this->emailSend($sslGet[0]['name']);
                return ['message' => 'Данные экспортированы'];
                }
        }

        /*
         * Создаем сертификат
         * */
        $sslNameGenerate = Str::uuid();
        $sslCreate = $this->client->query(
            (new Query('/certificate/add'))
                ->equal('name', $sslNameGenerate)
                ->equal('country', 'RU')
                ->equal('state', '72')
                ->equal('locality', $this->user['locality'])
                ->equal('organization', 'KRiMM')
                ->equal('unit', 'IT')
                ->equal('common-name', $this->user['common_name'])
                ->equal('key-size', 2048)
                ->equal('days-valid', env('MIKROTIK_SSL_DAYS_VALID'))
                ->equal('key-usage', 'tls-client')
        )->read();

        /*
         * Подписываем сертификат корневым
         * вынести в очереди / убрать выгрузку и создание настроек
         * */


        if (array_key_exists('after', $sslCreate)){
            if (array_key_exists('ret',$sslCreate['after'])){
                SSLSign::dispatch($sslCreate['after']['ret']);
                return ['message' => 'SSL sign'];
            }
        }
        return ['message' => 'Error'];
    }

    private function arhiveAdd($fileName): void
    {
        $zip = new ZipArchive;
        if ($zip->open($this->path_temp .$fileName.'.zip', ZipArchive::CREATE) === TRUE) {
            $zip->addFile($this->path_temp. $fileName.'.p12', 'ssl_'.$fileName.'.p12');
            $zip->addFile($this->path_temp . $fileName, 'script_'.$fileName.'.ps1');
            $zip->close();
        }
    }

    private function emailSend($fileName)
    {
        Bus::chain([
            new VPNSendEmailAccess($this->user['email'], $this->user['full_name'], $this->path_temp .$fileName.'.zip'),
            new VPNFileClear($this->path_temp, $fileName),
        ])->dispatch();
    }

    private function downloadMikrotikToStorage($fileName)
    {
        Storage::put('/temp/'.$fileName.'.p12',Storage::disk('ftp')->get('/cert_export_'.$fileName.'.p12'));
    }

    private function exportSSL($fileID): void
    {
        $password = rand(10000000,99999999);

        $this->client->query((new Query('/certificate/export-certificate'))
            ->equal('.id', $fileID)
            ->equal('type', 'pkcs12')
            ->equal('export-passphrase', $password)
        )->read();

        $sendPassword = new SmsSend();
        $sendPassword->send($this->user['phone'], 'Доступ к файлу - '.$password);
    }

    private function identityCreate($sslName)
    {
        $identityFind = $this->client->query(
            (new Query('/ip/ipsec/identity/print'))
                ->where('mode-config', $this->user['common_name']))
            ->read();

        if (array_key_exists(0, $identityFind)) {
            $this->client->query(
                (new Query ('/ip/ipsec/identity/set'))
                    ->equal('.id', $identityFind[0]['.id'])
                    ->equal('certificate',env('MIKROTIK_SSL_SERVER'))
                    ->equal('remote-certificate',$sslName)
            )
                ->read();
        } else {
            $this->client->query(
                (new Query('/ip/ipsec/identity/add'))
                    ->equal('peer','IKEv2-Peer')
                    ->equal('auth-method','digital-signature')
                    ->equal('certificate',env('MIKROTIK_SSL_SERVER'))
                    ->equal('remote-certificate',$sslName)
                    ->equal('policy-template-group','IKEv2-Group')
                    ->equal('my-id','auto')
                    ->equal('remote-id','auto')
                    ->equal('match-by','certificate')
                    ->equal('mode-config',$this->user['common_name'])
                    ->equal('generate-policy','port-strict')
            )->read();
        }
    }

    public function createPowerShell($fileName)
    {

        $data = sprintf(
            'Set-ExecutionPolicy -Scope CurrentUser RemoteSigned'.PHP_EOL.
            'if (-NOT ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole(`'.PHP_EOL.
            '[Security.Principal.WindowsBuiltInRole] "Administrator")) {'.PHP_EOL.
            'Start-Process powershell.exe -Verb RunAs -ArgumentList (\'-noprofile -noexit -file "{0}" -elevated\' -f ( $myinvocation.MyCommand.Definition ))'.PHP_EOL.
            'Break}'.PHP_EOL.
            'Get-VpnConnection | Where-Object { $_.Name -eq \'VPN-KRiMM\'} | Remove-VpnConnection -Name "VPN-KRiMM" -Force'.PHP_EOL.
            'Add-VpnConnection -Name "VPN-KRiMM" -ServerAddress "welcome.krimm.ru" -TunnelType Ikev2 -AuthenticationMethod MachineCertificate -SplitTunneling -PassThru'.PHP_EOL.
            '$DesktopPath = [Environment]::GetFolderPath("Desktop")'.PHP_EOL.
            '$OFS = "`r`n"'.PHP_EOL.
            '$msg = "username:s:krimm\%s" + $OFS + "full address:s:%s"'.PHP_EOL.
            'New-Item -Path $DesktopPath -Name "KRiMM.rdp" -ItemType "file" -Value $msg -Force'.PHP_EOL.
            'Get-ChildItem -Path Cert:\LocalMachine\My | Where-Object { $_.FriendlyName -eq \'%s\' } | Remove-Item'

            , $this->user['login_domain'], $this->user['ip_domain'], $this->user['revoke_friendly_name']);

        file_put_contents($fileName, $data);
    }
}
