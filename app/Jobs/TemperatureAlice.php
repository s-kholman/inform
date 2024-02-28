<?php

namespace App\Jobs;

use App\Models\Yandex\Temperature;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\MqttClient;

class TemperatureAlice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $temperature;
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->temperature = null;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $temperature = $this->get();
        if($temperature <> null)
        {
            Temperature::query()->create(
                [
                    'date' => new \DateTime(),
                    'temperature' => $temperature,
                    'thermometerName' => 'sarai',
                ]
            );
        }
    }

    private function get()
    {
        $server   = '194.67.109.99';
        $port     = 8890;
        $clientId = 'InformKRiMM';
        $mqtt = new MqttClient($server, $port, $clientId);

        $connectionSettings = (new ConnectionSettings())
            ->setUsername('4')
            ->setPassword('4');
        $mqtt->connect($connectionSettings, true);
        $mqtt->subscribe('sarai/temperature', function ($topic, $message, $retained, $matchedWildcards) use ($mqtt){
            $this->temperature = (float)$message;
            $mqtt->interrupt();
        }, 0);
        $mqtt->loop(true);
        $mqtt->disconnect();
        if (filter_var($this->temperature, FILTER_VALIDATE_FLOAT)){
            return (float)$this->temperature;
        } else {
            return null;
        }
    }
}
