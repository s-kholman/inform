<?php

namespace App\Actions\peat;

use App\Actions\harvest\HarvestAction;
use App\Actions\harvest\HarvestShow;
use App\Models\Peat;
use Illuminate\Support\Carbon;

class PeatShowAction extends HarvestAction
{
    public function handle($harvest = null): array
    {
        if ($harvest == null) {
            $harvest = parent::HarvestYear(Carbon::now());
        }
        $all = Peat::query()
            ->select('peats.*', 'filials.name as filial_name', 'poles.name as pole_name')
            ->where('harvest_year_id', $harvest)
            ->join('filials', 'filials.id', '=', 'peats.filial_id')
            ->join('poles', 'poles.id', '=', 'peats.pole_id')
            ->orderBy('filials.name')
            ->orderBy('poles.name')
            ->get();

        $harvest_all = Peat::query()
            ->select('harvest_year_id', 'harvest_years.name as harvest_name')
            ->join('harvest_years', 'harvest_years.id', '=', 'peats.harvest_year_id')
            ->orderByDesc('harvest_years.name')
            ->get()
            ->unique('harvest_year_id')
            ->groupBy('harvest_year_id');

        $harvestShow = new HarvestShow();
        $harvest_show = $harvestShow->HarvestShow($harvest_all);
        //Группировка по датам, взяли первую дату
        foreach ($all->groupBy('date') as $date => $value) {
            $summa = 0;
            //Применяем матрицу таблицы на каждый день вне зависимости от наличия данных
            //Филиал
            foreach ($all->groupBy(['filial_id', 'peat_extraction_id', 'pole_id']) as $filial_id => $extraction) {
                //Место добычи
                foreach ($extraction as $extraction_id => $pole) {
                    //Поле
                    foreach ($pole as $pole_id => $nulls) {
                        foreach ($value as $key) {

                            if ($key->date == $date and $key->filial_id == $filial_id and $key->peat_extraction_id == $extraction_id and $pole_id == $key->pole_id) {
                                $result [$date] [$filial_id] [$extraction_id] [$pole_id] = $key;
                                $summa += $key->volume;
                                break;
                            } else {
                                $result [$date] [$filial_id] [$extraction_id] [$pole_id] = null;
                            }
                        }
                    }
                }
            }
            $summa_arr [$date] ['summa'] = $summa;
        }
        if (!empty($result)) {
            krsort($result);
            return [
                'result' => $result,
                'summa_arr' => $summa_arr,
                'harvest_year_id' => $harvest,
                'harvest_all' => $harvest_all,
                'harvest_show' => $harvest_show,
            ];
        } else
            return
                [
                    'result' => $result = 0,
                    'summa_arr' => $summa_arr = 0,
                    'harvest_year_id' => $harvest,
                    'harvest_all' => $harvest_all,
                    'harvest_show' => [],
                ];
    }
}
