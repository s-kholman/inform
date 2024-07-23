<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Models\HarvestYear;
use App\Models\Spraying;
use App\Models\Szr;
use Illuminate\Http\Request;

class SprayingReportController extends Controller
{
    public function index(){

        $spraying_date = Spraying::query()
            ->select('date')
            ->orderByDesc('date')
            ->first()
            ;

        $sprayings = Spraying::where('date', $spraying_date->date)->get();

        foreach ($sprayings as $spraying)
        {
            $arr_value [$spraying->pole->filial_id] [$spraying->pole->name] [$spraying->szr->name] = $spraying->volume;
        }

        return view('spraying.report.one_date', ['arr_value' => $arr_value, 'date' =>  $spraying_date->date]);

    }

    public function report(Request $request){
        $arr_value = [];

        $sprayings = Spraying::where('date', $request->date)->get();


            foreach ($sprayings as $spraying)
            {
                $arr_value [$spraying->pole->filial_id] [$spraying->pole->name] [$spraying->szr->name] = $spraying->volume;
            }

        return view('spraying.report.one_date', ['arr_value' => $arr_value, 'date' => $request->date]);

    }

    public function szr(HarvestAction $harvestAction)
    {

        $szrs = Spraying::query()
            ->with(['filial', 'Sevooborot', 'pole', 'szr'])
            ->get()
            ->where('Sevooborot.harvest_year_id', $harvestAction->HarvestYear(now()))
            ->sortByDesc(['filial.name', 'szr.name'])
            ->groupBy(['filial.name', 'szr.name'])

        ;


        //dd($szrs->groupBy(['filial.name', 'pole.name', 'szr.name']));

        return view('spraying/report/szr', ['szrs' => $szrs]);
    }
}
