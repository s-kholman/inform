<?php

namespace App\Http\Controllers\Cabinet\VPN\Schedule;

use App\Jobs\RemoveSettingsVPNJobs;
use RouterOS\Client;
use RouterOS\Query;

class RemoveSettings
{
    protected Client $client;

    /**
     * @throws \RouterOS\Exceptions\ClientException
     * @throws \RouterOS\Exceptions\ConnectException
     * @throws \RouterOS\Exceptions\QueryException
     * @throws \RouterOS\Exceptions\BadCredentialsException
     * @throws \RouterOS\Exceptions\ConfigException
     */
    public function __construct()
    {
        $this->client = new Client(
            [
                'host' => env('MIKROTIK_HOST'),
                'user' => env('MIKROTIK_USERNAME'),
                'pass' => env('MIKROTIK_PASSWORD'),
                'port' => 8728
            ]
        );
    }

    public function __invoke()
    {

        $activeCertificate = array_filter($this->certificateGet(), function ($var){
           return !array_key_exists('expired', $var);
        });

        $identitiesNoActive = array_filter($this->identitiesGetAll(), function ($var) use ($activeCertificate){
            foreach ($activeCertificate as $item){
                if ($item['name'] == $var['remote-certificate']){
                    return false;
                }
            }
            return true;
        });

        foreach ($identitiesNoActive as $value){
               dispatch(new RemoveSettingsVPNJobs($value));
        }

    }


    private function identitiesGetAll()
    {
        return $this->client->query(
            (new Query('/ip/ipsec/identity/print'))
        )
            ->read();
    }

    private function certificateGet()
    {
        return $this->client->query(
            (new Query('/certificate/print'))
                ->where('key-usage', 'tls-client')
                ->where('issued', 'true')
        )->read();
    }
}
