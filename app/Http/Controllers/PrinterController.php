<?php

namespace App\Http\Controllers;

use App\Models\CurrentStatus;
use App\Models\DailyUse;
use App\Models\Device;
use App\Models\Service;
use Carbon\Carbon;
use FreeDSx\Snmp\Exception\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Nelisys\Snmp;

class PrinterController extends Controller
{
    public function show($device_id, CurrentStatus $currentStatus)
    {
        return view('printer.show', ['id' => $device_id, 'currentStatus' => $currentStatus]);
    }

    public function testSNMP ()
    {
        /*$snmp = new \Ndum\Laravel\Snmp();
        $snmp->newClient('192.168.0.24', '2', 'public');
        $dd = $snmp->getValue('1.3.6.1.2.1.43.11.1.1.9.1.1');
        dd($dd);*/
        $sql = DB::table('daily_uses')
            ->select('date', 'count')
            ->selectRaw(' toner - lead(toner) OVER (order by date) AS itog ')
            ->where('device_id',  18)
            ->get();
        ;
        $cartridg = $sql->where('itog', '<', -1)->sortByDesc('date')->take(4);
        dd($cartridg);
    }

    public function index(Request $request)
    {

        /**
         * Смотрим переменную $date если в POST ничего не пришло, то берем текущею
         * $status Получаем текущие устройства со статусом
         * $device Форматируем коллекцию (сортируем, оставляем только неповторяющиеся, сортирум по филиалу, удаляем в стутсе false
         * В первом цикле берем последнию запись, но не за сегодня
         * Во втором запросе получаем данные за сегодня
         * Во втором цикле получаем последнее показания о тоноре и количестве распечаток
         * в toDayCount ложим разницу между двумя значениями
         * В переменную $summa ложим сумму коллекции по столбцу
         */

        $date = $request->date;
        if ($date == null){
            $date = Carbon::now();
        }

        $status = CurrentStatus::with('status')->where('date','<=', $date)->get();
        $device = $status->
        sortByDesc('date')->
        sortByDesc('created_at')->
        unique(['device_id'])->
        sortBy('filial.name')->
        whereNotIn('status.active', false);
        foreach ($device as $id => $value){
         $dual [$id] [] =  DailyUse::where('device_id',$value->device_id)->where('date', '<', $date)->latest('date')->take(1)->get();
         $dual [$id] []=  DailyUse::where('device_id',$value->device_id)->where('date', $date)->get();
    }

        foreach ($dual as $id => $value)
        {
            if ($value[0]->isNotEmpty() && $value[1]->isNotEmpty()){
                $result [$id] = [
                    'toner' => $value[1][0]->toner,
                    'count' => $value[1][0]->count,
                    'toDayCount' => $value[1][0]->count-$value[0][0]->count
                ];
            } elseif ($value[0]->isNotEmpty() && $value[1]->isEmpty()){
                $result [$id] = [
                    'toner' => $value[0][0]->toner,
                    'count' => $value[0][0]->count,
                    'toDayCount' => 0
                    ];
            } elseif ($value[0]->isEmpty() && $value[1]->isEmpty()){
                $result [$id] = [
                    'toner' => 'н/д',
                    'count' => 'н/д',
                    'toDayCount' => 'н/д'
                ];
            }
        }

        $summa = collect($result)->sum('toDayCount');

        return view('printer.index', ['device' => $device, 'result' => $result, 'summa' => $summa, 'date' => $date]);
    }

    public function daily()
{
    dump(time());
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
        DailyUse::updateOrCreate(
            [
                'device_id' => $device,
                'date' =>Carbon::now()
            ],
            [
                'toner' => $this->kyocera($value),
                'count' => $this->count($value, $device)
            ]);
    }
    dump(time());
    return 'Выполнение скрипта оконченно';

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
        /**
         * Количество страниц запрошенные с принтера
         * Если в массиве есть ключи, передаем их значения
         * Если ключей не обнаруженно, то передаем последнее сохранненое значение
         */
        if (array_key_exists('1.3.6.1.4.1.1347.43.10.1.1.12.1.1', $value)){
            return $value['1.3.6.1.4.1.1347.43.10.1.1.12.1.1'];
        } elseif (array_key_exists('1.3.6.1.2.1.43.10.2.1.4.1.1', $value)){
            return $value['1.3.6.1.2.1.43.10.2.1.4.1.1'];
        } else {
            return DailyUse::where('device_id',$device)->latest('date')->take(1)->value('count');
        }
    }

    public function job()
    {
        RateLimiter::attempt('DailyUse',  1, function (){
            dispatch(new \App\Jobs\DailyUse());
            return null;
        },  60*5);
    }

    public function toDayGet (Request $request)
    {
        dd($request);
    }

}
