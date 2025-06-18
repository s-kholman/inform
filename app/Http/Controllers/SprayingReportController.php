<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Http\Requests\SprayingReportRequest;
use App\Models\Spraying;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SprayingReportController extends Controller
{
    public function oneDate(SprayingReportRequest $request){

        $harvest = new HarvestAction();
        $year = $harvest->HarvestYear(now());

        $check = DB::select("WITH CTE AS (
            SELECT sprayings.id as id, sprayings.date, interval_day_start, interval_day_end, filials.name as filial_name, poles.name as pole_name,
            szrs.name as szr_name,
            ROW_NUMBER() OVER (PARTITION BY sprayings.pole_id ORDER BY date DESC) AS Rnk
            FROM sprayings
            LEFT JOIN szrs ON sprayings.szr_id = szrs.id
            LEFT JOIN sevooborots ON sprayings.sevooborot_id = sevooborots.id
            LEFT JOIN poles ON sprayings.pole_id = poles.id
            LEFT JOIN filials ON poles.filial_id = filials.id
            where interval_day_start IS NOT NULL AND harvest_year_id = $year AND deleted_at IS NULL
)
SELECT * FROM CTE WHERE Rnk = 1");

        $export = array_filter($check, function ($var) {
            return Carbon::parse($var->date)->addDays($var->interval_day_end)->lessThan(now());
        });

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

        return view('spraying.report.one_date',
            [
                'arr_value' => $arr_value,
                'date' =>  $spraying_date,
                'export' => collect($export)->sortByDesc('date')->groupBy('filial_name')
            ]);

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
