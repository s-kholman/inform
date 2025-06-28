<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use RouterOS\Client;
use RouterOS\Query;

class RemoveSettingsVPNJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $identities)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client(
            [
                'host' => env('MIKROTIK_HOST'),
                'user' => env('MIKROTIK_USERNAME'),
                'pass' => env('MIKROTIK_PASSWORD'),
                'port' => 8728
            ]
        );

        $client->query(
            (new Query('/ip/ipsec/identity/remove'))
                ->equal('.id',$this->identities['.id'])
        )->read();

        $id = $client->query(
            (new Query('/ip/ipsec/mode-config/print'))
                ->where('name', $this->identities['mode-config']))
            ->read();

        $client->query(
            (new Query('/ip/ipsec/mode-config/remove'))
                ->equal('.id',$id[0]['.id'])
        )->read();
    }
}
