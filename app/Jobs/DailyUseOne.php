<?php

namespace App\Jobs;

use Carbon\Carbon;
use FreeDSx\Snmp\Exception\ConnectionException;
use FreeDSx\Snmp\Exception\SnmpRequestException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ndum\Laravel\Snmp;

class DailyUseOne implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $device = '';
    /**
     * Create a new job instance.
     */
    public function __construct($device)
    {
        $this->device=$device;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $out = [];
            exec("ping -n 1 -w 100 " . $this->device->ip . " 2>NUL > NUL && (echo 0) || (echo 1)", $output, $status);
            if (!$output[0]) {
                $model = $this->device->devicename;
                $snmp = new Snmp();
                $snmp->newClient($this->device->ip, '2', 'public');
                foreach ($model->miboid->pluck('name')->toArray() as $oid)
                {
                    try {
                        $get_snmp = $snmp->getValue($oid);
                        if ($get_snmp == '') {
                            unset($out);
                            break;
                        } else {
                            $out [$oid] = $get_snmp;
                        }

                    } catch (ConnectionException $e) {
                        unset($out);
                        $this->fail($this->device->ip . 'ConnectionException ' . $e);
                        break;

                    } catch (SnmpRequestException $e) {
                        $this->fail($this->device->ip . 'SnmpRequestException ' . $e);
                    }

                }
                if (!empty($out))
                {
                    $this->store($this->device->device_id, $out);
                    unset($out);
                }
            }
            $this->fail("no ping $this->device->ip");
    }

    /**
     * Проверяем по бренду какие данные записывать
     * Проверяем наличие данных вообще
     * В случае kyocera высчитываем остаток тонера function kyocera
     * Страницы получаем с function count
     */

    private function kyocera ($value)
    {
        if (array_key_exists ('1.3.6.1.2.1.43.11.1.1.8.1.1', $value) && array_key_exists('1.3.6.1.2.1.43.11.1.1.9.1.1', $value)){
            $toner = $value['1.3.6.1.2.1.43.11.1.1.9.1.1']/($value['1.3.6.1.2.1.43.11.1.1.8.1.1']/100);
        } else {
            $toner = 100;
        }
        return $toner;
    }

    private function count ($value, $device)
    {

        if (array_key_exists('1.3.6.1.4.1.1347.43.10.1.1.12.1.1', $value)){
            return $value['1.3.6.1.4.1.1347.43.10.1.1.12.1.1'];
        } elseif (array_key_exists('1.3.6.1.2.1.43.10.2.1.4.1.1', $value)){
            return $value['1.3.6.1.2.1.43.10.2.1.4.1.1'];
        } else {
            return DailyUse::where('device_id',$device)->latest('date')->take(1)->value('count');
        }
    }

    private function store(int $device,array $value): void
    {
        \App\Models\DailyUse::updateOrCreate(
            [
                'device_id' => $device,
                'date' => Carbon::now()
            ],
            [
                'toner' => $this->kyocera($value),
                'count' => $this->count($value, $device)
            ]);
    }
}
