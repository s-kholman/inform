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

class SSLSign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private string $id;

    public function __construct($id)
    {

        $this->id = $id;
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

        $client->query((new Query(' /certificate/sign'))
            ->equal('ca', env('MIKROTIK_SSL_CA'))
            ->equal('number', $this->id)
        )->read();
    }
}
