<?php

namespace App\Actions\Printer;

use App\Models\CurrentStatus;
use App\Models\DailyUse;
use App\Models\filial;

class IndexAction
{
    public function __invoke($date): array
    {
        /**
         * В переменной $date данные с POST, если пусто берем по умолчанию текущий день
         * $status Получаем текущие устройства со статусом
         * Форматируем коллекцию (сортируем, оставляем только неповторяющиеся, сортируем по филиалу, удаляем в статусе false
         * В первом цикле берем последнею запись, но не за сегодня
         * Во втором запросе получаем данные за сегодня
         * Во втором цикле получаем последнее показания о тоноре и количестве распечаток
         * в toDayCount разница между двумя значениями
         * В переменную $summa сумма коллекции по столбцу
         */

        $status = CurrentStatus::query()
            ->distinct('device_id')
            ->with(['status', 'DeviceNames'])
            ->where('date','<=', $date)
            ->whereHas('status', function ($query) {
                $query->where('active', true);
            })
            ->get()
            ->collect()
            ->sortBy('filial.name');

        foreach ($status as $id => $value){

            $temp =  DailyUse::query()
                ->where('device_id',$value->device_id)
                ->where('date', '<=', $date)
                ->latest('date')
                ->take(2)
                ->get();

                if ($temp->count() == 2 && $temp[0]->date == now()->format('Y-m-d')){
                    $result [$id] = [
                        'toner' => $temp[0]->toner,
                        'count' => $temp[0]->count,
                        'toDayCount' => $temp[0]->count-$temp[1]->count,
                        'color' => $this->color($temp[0]->toner)
                    ];
                } elseif($temp->count() >= 1 && $temp[0]->date <> now()->format('Y-m-d')){
                    $result [$id] = [
                        'toner' => $temp[0]->toner,
                        'count' => $temp[0]->count,
                        'toDayCount' => 0,
                        'color' => $this->color($temp[0]->toner)
                    ];
                } else{
                    $result [$id] = [
                        'toner' => 'н/д',
                        'count' => 0,
                        'toDayCount' => 0,
                        'color' => '#ff0000'
                    ];
                }
        }

        $summa = collect($result)->sum('toDayCount');

        return ['summa'=>$summa, 'result' => $result, 'device' => $status];
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
