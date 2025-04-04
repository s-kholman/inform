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
                    'toDayCount' => $value[1][0]->count-$value[0][0]->count,
                    'color' => $this->color($value[1][0]->toner)
                ];
            } elseif ($value[0]->isNotEmpty() && $value[1]->isEmpty()){
                $result [$id] = [
                    'toner' => $value[0][0]->toner,
                    'count' => $value[0][0]->count,
                    'toDayCount' => 0,
                    'color' => $this->color($value[0][0]->toner)
                ];
            } elseif ($value[0]->isEmpty() && $value[1]->isEmpty()){
                $result [$id] = [
                    'toner' => 'н/д',
                    'count' => 0,
                    'toDayCount' => 0,
                    'color' => '#ff0000'
                ];
            }
        }

        $summa = collect($result)->sum('toDayCount');

        return ['summa'=>$summa, 'result' => $result, 'device' => $device];
    }

    public function color ($toner_count): string
    {
        if ($toner_count > 0 and $toner_count <= 10){
            return '#ff0000';
        }
        elseif ($toner_count > 10 and $toner_count <= 20){
            return '#ff4d00';
        }
        elseif ($toner_count > 20 and $toner_count <= 40){
            return '#ff9800';
        }
        elseif ($toner_count > 40 and $toner_count <= 60){
            return '#ffeb3b';
        }
        elseif ($toner_count > 60 and $toner_count <= 80){
            return '#8bc34a';
        }
        elseif ($toner_count > 80 and $toner_count <= 100){
            return '#8bff04';
        }
        else {
            return '#ffffff';
        }
    }

}
