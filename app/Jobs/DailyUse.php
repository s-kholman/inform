<?php

namespace App\Jobs;

use App\Models\CurrentStatus;
use Carbon\Carbon;
use FreeDSx\Snmp\Exception\ConnectionException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DailyUse implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /**
         * Получаем коллекцию, вместе со связью
         */
        $status = CurrentStatus::with('status')->get();
        /**
         * Сортируем коллекцию
         * Удаляем дубли устройств
         * Сортируем по названию филиала через связь
         * Удаляем в статусе false, также через связь
         */
        $device = $status->
        sortByDesc('date')->
        unique(['device_id'])->
        sortBy('filial.name')->
        whereNotIn('status.active', false);

        /**
         * Цикл по колеекции
         * Проверяем с помощь ping доступность устройств в сети
         * Создаем объект для SNMP и задаем начальные параметры
         * Во втором цикле получаем MIB_OID
         * Помещаем выполнение в try если устройство не сможет дать ответ
         * Собираем выходной массив с данными опроса устройств
         */
        foreach ($device as $item) {
            exec("ping -n 1 -w 100 " . $item->ip . " 2>NUL > NUL && (echo 0) || (echo 1)", $output, $status);
            if (!$output[0]) {
                $model = $item->devicename;
                $snmp = new \Ndum\Laravel\Snmp();
                $snmp->newClient($item->ip, '2', 'public');
                foreach ($model->miboid->pluck('name')->toArray() as $oid)
                {
                    try
                    {
                        $out [$item->device_id] [$oid] = $snmp->getValue($oid);

                    }
                    catch (ConnectionException)
                    {

                    }

                }
            }

        }
        /**
         * Проверяем по бренду какие данные записывать
         * Проверяем наличие данных вообще
         * В случае kyocera высчитываем остаток тонера function kyocera
         * Страницы получаем с function count
         */

        foreach ($out as $device => $value)
        {
            \App\Models\DailyUse::updateOrCreate(
                [
                    'device_id' => $device,
                    'date' =>Carbon::now()
                ],
                [
                    'toner' => $this->kyocera($value),
                    'count' => $this->count($value, $device)
                ]);
        }
    }

    private function kyocera ($data)
    {
        if (array_key_exists ('1.3.6.1.2.1.43.11.1.1.8.1.1', $data) && array_key_exists('1.3.6.1.2.1.43.11.1.1.9.1.1', $data)){
            $toner = $data['1.3.6.1.2.1.43.11.1.1.9.1.1']/($data['1.3.6.1.2.1.43.11.1.1.8.1.1']/100);
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
}
