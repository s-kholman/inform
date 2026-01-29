<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SMS\Send\SmsSend;
use App\Jobs\SSLSign;
use App\Models\VpnInfo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RouterOS\Client;
use RouterOS\Query;


class MikrotikController extends Controller
{
    public $sslActive;
    public $modeConfig;
    private $identity;
    private $newSSL;
    public bool $sing = false;

    private Client $client;

    public UserVPN $user;

    public function __construct(UserVPN $user)
    {
        $this->client = new Client(
            [
                'host' => env('MIKROTIK_HOST'),
                'user' => env('MIKROTIK_USERNAME'),
                'pass' => env('MIKROTIK_PASSWORD'),
                'port' => 8728
            ]
        );

        $this->user = $user;

    }



    public function modeConfigGet()
    {
        $this->modeConfig = $this->client->query(
            (new Query('/ip/ipsec/mode-config/print'))
                ->where('name', $this->user->common_name()))
            ->read();
        return $this;
    }

    public function getAddressStatic()
    {
        if (!empty($this->modeConfig)){
            if (array_key_exists(0,$this->modeConfig)) {
                if (array_key_exists('address', $this->modeConfig[0])) {
                    return $this->modeConfig[0]['address'];
                }
            }
        }
    }

    public function modeConfigRemove()
    {
        if (!empty($this->modeConfig)){
            $this->client->query(
                (new Query('/ip/ipsec/mode-config/remove'))
                    ->equal('.id', $this->modeConfig[0]['.id']))
                ->read();
            $this->modeConfig = '';
        }
        return $this;
    }

    public function checkIpModeConfig()
    {
        if (array_key_exists(0,$this->modeConfig)){
            $position = strpos($this->modeConfig[0]['split-include'], '/');
            $result = substr($this->modeConfig[0]['split-include'], 0, $position);
            if ($result != $this->user->ip_domain()){
                $this->client->query(
                    (new Query ('/ip/ipsec/mode-config/set'))
                        ->equal('.id', $this->modeConfig[0]['.id'])
                        ->equal('split-include', $this->user->ip_domain())
                )
                    ->read();
            }
        }
        return $this;
    }


    public function modeConfigAddStaticIP()
    {
        if (!array_key_exists(0, $this->modeConfig)){
                $this->client->query(
                    (new Query('/ip/ipsec/mode-config/add'))
                        ->equal('address', $this->getIpClient())
                        ->equal('name', $this->user->common_name())
                        ->equal('split-include', $this->user->ip_domain())
                )
                    ->read();
        }
        return $this;
    }

    public function modeConfigAddDynamicIP()
    {
        if (!array_key_exists(0, $this->modeConfig)){
            $this->client->query(
                (new Query('/ip/ipsec/mode-config/add'))
                    ->equal('address-pool', 'POOL-IKEv2')
                    ->equal('address-prefix-length', '32')
                    ->equal('name', $this->user->common_name())
                    ->equal('split-include', $this->user->ip_domain()))
                ->read();
        }
        return $this;
    }

    private function getIpClient()
    {
        $pool_start = '192.168.55.';
        $pool_length = 81+30;
        $pool = [];

        for($i = 81; $pool_length >= $i; ++$i){
            $pool [$pool_start.$i] = true;
        }

        $getModeConfig = $this->client->query(
            (new Query('/ip/ipsec/mode-config/print'))
                ->where('address'))
            ->read();

        foreach ($getModeConfig as $modeConfig){
            if (array_key_exists($modeConfig['address'], $pool)){
                unset($pool[$modeConfig['address']]);
            }

        }
        return array_key_first($pool);
    }

    public function sslGetActive()
    {
        $this->sslActive = $this->client->query(
            (new Query('/certificate/print'))
                ->where('issued', "true")
                ->where('common-name', $this->user->common_name())
        )->read();

        return $this;
    }

    public function sslCreate()
    {
        if (empty($this->sslActive)){
            $this->sslNameGenerate = Str::uuid();
            $this->newSSL = $this->client->query(
                (new Query('/certificate/add'))
                    ->equal('name', $this->sslNameGenerate)
                    ->equal('country', 'RU')
                    ->equal('state', '72')
                    ->equal('locality', $this->user->locality())
                    ->equal('organization', 'KRiMM')
                    ->equal('common-name', $this->user->common_name())
                    ->equal('key-size', 2048)
                    ->equal('days-valid', env('MIKROTIK_SSL_DAYS_VALID'))
                    ->equal('key-usage', 'tls-client')
            )->read();
        }
        return $this;
    }

    public function sslSing()
    {
        if(!empty($this->newSSL)){
            if (array_key_exists('after', $this->newSSL)){
                if (array_key_exists('ret',$this->newSSL['after'])){
                     SSLSign::dispatch($this->newSSL['after']['ret']);
                     $this->sing = true;
                }
            }
        }
        return $this;
    }

    public function sslCheckInvalidAfter()
    {
        if (!empty($this->sslActive)){
            $day = Carbon::parse(date('Y-m-d',strtotime(Str::replace('/', ' ', $this->sslActive[0]['invalid-after']))))->diffInDays(now());
            if ($day < 0){
                $day = $day *-1;
            }
            if ($day <= 30) {
                $this->sslRevoke();
            }
        }
        return $this;
    }

    public function sslRevoke()
    {
        if (!empty($this->sslActive)){
            $revoke = (new Query('/certificate/issued-revoke'))
                ->equal('.id', $this->sslActive[0]['.id']);
            $this->client->query($revoke)->read();
            VpnInfo::query()
                ->where('registration_id', $this->user->registration_id())
                ->update(['revoke_friendly_name' => $this->sslActive[0]['name']
            ]);
            $this->sslActive = '';
        }
        return $this;
    }

    public function identityGet()
    {
        $this->identity = $this->client->query(
            (new Query('/ip/ipsec/identity/print'))
                ->where('mode-config', $this->user->common_name()))
            ->read();
        return $this;
    }

    public function identitySet()
    {
        if (!empty($this->identity)){
            if (array_key_exists(0, $this->identity)) {
                $this->client->query(
                    (new Query ('/ip/ipsec/identity/set'))
                        ->equal('.id', $this->identity[0]['.id'])
                        ->equal('certificate',env('MIKROTIK_SSL_SERVER'))
                        ->equal('remote-certificate',$this->sslActive[0]['name'])
                )
                    ->read();
            }
        }
        return $this;
    }

    public function identityAdd()
    {
        if (empty($this->identity)){
            $this->client->query(
                (new Query('/ip/ipsec/identity/add'))
                    ->equal('peer','IKEv2-Peer')
                    ->equal('auth-method','digital-signature')
                    ->equal('certificate',env('MIKROTIK_SSL_SERVER'))
                    ->equal('remote-certificate',$this->sslActive[0]['name'])
                    ->equal('policy-template-group','IKEv2-Group')
                    ->equal('my-id','auto')
                    ->equal('remote-id','auto')
                    ->equal('match-by','certificate')
                    ->equal('mode-config',$this->user->common_name())
                    ->equal('generate-policy','port-strict')
            )->read();
        }
        return $this;
    }

    public function identityRemove()
    {
        if (!empty($this->identity)){
            $this->client->query(
                (new Query('/ip/ipsec/identity/remove'))
                    ->equal('.id',$this->identity[0]['.id'])
            )->read();
        }
        $this->identity = '';
        return $this;
    }

    public function exportSSL(): void
    {
        $password = rand(10000000,99999999);

        $this->client->query((new Query('/certificate/export-certificate'))
            ->equal('.id', $this->sslActive[0]['.id'])
            ->equal('type', 'pkcs12')
            ->equal('export-passphrase', $password)
        )->read();

        $sendPassword = new SmsSend();
        $sendPassword->send($this->user->phone(), 'Доступ к файлу - '.$password);
    }
}
