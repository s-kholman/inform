<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Http\Requests\SprayingReportRequest;
use App\Models\Spraying;

class SprayingReportController extends Controller
{
    public function oneDate(SprayingReportRequest $request){

        $arr_value = [];
        if (empty($request->date)){
            $spraying_date = Spraying::query()
                ->select('date')
                ->orderByDesc('date')
                ->first('date')->date;
        } else {
            $spraying_date = $request['date'];
        }

        $sprayings = Spraying::query()
            ->where('date', $spraying_date)
            ->get();

        foreach ($sprayings as $spraying)
        {
            $arr_value [$spraying->pole->filial_id] [$spraying->pole->name] [$spraying->szr->name] = $spraying->volume;
        }

        return view('spraying.report.one_date', ['arr_value' => $arr_value, 'date' =>  $spraying_date]);

    }

    public function szr(HarvestAction $harvestAction)
    {
        $szrs = Spraying::query()
            ->with(['filial', 'Sevooborot', 'pole', 'szr'])
            ->get()
            ->where('Sevooborot.harvest_year_id', $harvestAction->HarvestYear(now()))
            ->sortByDesc(['filial.name', 'szr.name'])
            ->groupBy(['filial.name', 'szr.name']);
        return view('spraying/report/szr', ['szrs' => $szrs]);
    }
}
