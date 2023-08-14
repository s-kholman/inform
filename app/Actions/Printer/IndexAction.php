<?php

namespace App\Actions\Printer;

use App\Models\CurrentStatus;
use App\Models\DailyUse;

class IndexAction
{
    public function __invoke($date): array
    {
        /**
         * Переменной $date присваем данные с POST, если пусто берем по умолчанию текущий день
         * $status Получаем текущие устройства со статусом
         * $device Форматируем коллекцию (сортируем, оставляем только неповторяющиеся, сортирум по филиалу, удаляем в стутсе false
         * В первом цикле берем последнию запись, но не за сегодня
         * Во втором запросе получаем данные за сегодня
         * Во втором цикле получаем последнее показания о тоноре и количестве распечаток
         * в toDayCount ложим разницу между двумя значениями
         * В переменную $summa ложим сумму коллекции по столбцу
         */

        $status = CurrentStatus::with('status')->with('DeviceNames')->where('date','<=', $date)->get();

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
                    'count' => 0,
                    'toDayCount' => 0
                ];
            }
        }

        $summa = collect($result)->sum('toDayCount');

        return ['summa'=>$summa, 'result' => $result, 'device' => $device];
    }

}
