<?php

namespace App\Http\Controllers;

use App\Actions\Printer\IndexAction;
use App\Jobs\DailyUseOne;
use App\Models\CurrentStatus;
use App\Models\DailyUse;
use Carbon\Carbon;
use FreeDSx\Snmp\Exception\ConnectionException;
use FreeDSx\Snmp\Exception\SnmpRequestException;
use Illuminate\Http\Request;
use Ndum\Laravel\Snmp;

class PrinterController extends Controller
{
    public function show($device_id, CurrentStatus $currentStatus)
    {
        return view('printer.show', ['id' => $device_id, 'currentStatus' => $currentStatus]);
    }

    public function index(Request $request, IndexAction $indexAction)
    {
        $date = $request->input('date', Carbon::now());

        $return = $indexAction($date);

        return view('printer.index', ['device' => $return['device'], 'result' => $return['result'], 'summa' => $return['summa'], 'date' => $date]);
    }

    public function dailyOne()
    {
        $status = CurrentStatus::with('status')->get();
        $device = $status->
        sortByDesc('date')->
        unique(['device_id'])->
        sortBy('filial.name')->
        whereNotIn('status.active', false);
        foreach ($device as $value){
            dispatch(new DailyUseOne($value));
        }

    }

    public function daily()
    {
        dump(Carbon::now()->format('i:s:u'));
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
         * Проверяем на путоту полученный ответ по SNMP, если данные не полученныв полном объеме удаляем ключ
         * break отдаем управление внешнему циклу
         * Собираем выходной массив с данными опроса устройств
         */
        $out = [];
        foreach ($device as $item) {
            exec("ping -n 1 -w 100 " . $item->ip . " 2>NUL > NUL && (echo 0) || (echo 1)", $output, $status);
            if (!$output[0]) {
                $model = $item->devicename;
                $snmp = new Snmp();
                $snmp->newClient($item->ip, '2', 'public');
                foreach ($model->miboid->pluck('name')->toArray() as $oid) {
                    try {
                        $get_snmp = $snmp->getValue($oid);
                        if ($get_snmp == '') {
                            unset($out);
                            break;
                        } else {
                            $out [$oid] = $get_snmp;
                        }

                    } catch (ConnectionException) {
                            unset($out);
                            break;
                    } catch (SnmpRequestException $e) {
                        dump($e);
                    }
                }
            }
            if (!empty($out))
            {
                $this->store($item->device_id, $out);
                dump($item->ip);echo '<br>'; dump($out); echo '<br><br>';
                unset($out);
            }
        }
        /**
         * Проверяем по бренду какие данные записывать
         * Проверяем наличие данных вообще
         * В случае kyocera высчитываем остаток тонера function kyocera
         * Страницы получаем с function count
         */

/*
        foreach ($out as $device => $value) {
            DailyUse::updateOrCreate(
                [
                    'device_id' => $device,
                    'date' => Carbon::now()
                ],
                [
                    'toner' => $this->kyocera($value),
                    'count' => $this->count($value, $device)
                ]);
        }
*/
        dump(Carbon::now()->format('i:s:u'));
        return 'Выполнение скрипта оконченно,';

    }

    private function kyocera($value)
    {
        if (array_key_exists('1.3.6.1.2.1.43.11.1.1.8.1.1', $value) && array_key_exists('1.3.6.1.2.1.43.11.1.1.9.1.1', $value)) {
            $toner = $value['1.3.6.1.2.1.43.11.1.1.9.1.1'] / ($value['1.3.6.1.2.1.43.11.1.1.8.1.1'] / 100);
        } else {
            $toner = 100;
        }
        return $toner;
    }

    private function count($value, $device)
    {
        /**
         * Количество страниц запрошенные с принтера
         * Если в массиве есть ключи, передаем их значения
         * Если ключей не обнаруженно, то передаем последнее сохранненое значение
         */
        if (array_key_exists('1.3.6.1.4.1.1347.43.10.1.1.12.1.1', $value)) {
            return $value['1.3.6.1.4.1.1347.43.10.1.1.12.1.1'];
        } elseif (array_key_exists('1.3.6.1.2.1.43.10.2.1.4.1.1', $value)) {
            return $value['1.3.6.1.2.1.43.10.2.1.4.1.1'];
        } else {
            return DailyUse::where('device_id', $device)->latest('date')->take(1)->value('count');
        }
    }

    private function store(int $device,array $value):void
    {
        DailyUse::updateOrCreate(
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
