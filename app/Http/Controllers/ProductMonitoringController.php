<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Http\Requests\ProductMonitoringRequest;
use App\Http\Requests\ProductMonitoringUpdateRequest;
use App\Models\ProductMonitoring;
use App\Models\StorageMode;
use Illuminate\Http\Request;

class ProductMonitoringController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ProductMonitoring::class, 'monitoring');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $year = ProductMonitoring::query()
            ->with('harvestYear')
            ->distinct('harvest_year_id')
            ->limit(4)
            ->get()
            ->sortByDesc('harvestYear.name')
            ->groupBy('harvestYear.name');


        if (empty($request->year)) {
            if ($year->isNotEmpty()) {
                foreach ($year as $value) {
                    $harvest_year_id = $value[0]->harvestYear->id;
                    break;
                }
            }
        } else {
            $harvest_year_id = $request->year;
        }


        $filial = ProductMonitoring::query()
            ->with('Storagefilial')
            ->where('harvest_year_id', $harvest_year_id)
            ->get()
            ->unique('Storagefilial.nameFilial.name')
            ->sortBy('Storagefilial.nameFilial.name')
            ->groupBy('Storagefilial.nameFilial.name');

        // dd($filial);


        return view('production_monitoring.index', ['filial' => $filial, 'year' => $year]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('production_monitoring.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductMonitoringRequest $request, HarvestAction $harvestAction)
    {

        $date = ProductMonitoring::create(
            [
                'storage_name_id' => $request['storage'],
                'date' => $request['date'],
                'burtTemperature' => $request['tempBurt'],
                'burtAboveTemperature' => $request['tempAboveBurt'],
                'tuberTemperatureMorning' => $request['tempMorning'],
                'tuberTemperatureEvening' => $request['tempEvening'],
                'humidity' => $request['humidity'],
                'storage_phase_id' => $request['phase'],
                'condensate' => boolval($request['condensate']),
                'comment' => $request['comment'],
                'harvest_year_id' => $harvestAction->HarvestYear(now(), 8),
            ]
        );
        if ($request['timeUp'] <> null && $request['timeDown'] <> null) {
            StorageMode::create([
                'timeUp' => $request['timeUp'],
                'timeDown' => $request['timeDown'],
                'product_monitoring_id' => $date->id,
            ]);
        }
        return redirect()->route('monitoring.show.filial.all', ['storage_name_id' => $request['storage'], 'harvest_year_id' => $harvestAction->HarvestYear(now(), 8)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductMonitoring $monitoring)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductMonitoring $monitoring)
    {
        return view('production_monitoring.edit', ['monitoring' => $monitoring]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductMonitoringUpdateRequest $request, ProductMonitoring $monitoring)
    {

        ProductMonitoring::where('id', $monitoring->id)->
        update(
            [
                'burtTemperature' => array_key_exists('tempBurt', $request->all()) ? $request['tempBurt'] : $monitoring->burtTemperature,
                'tuberTemperatureMorning' => array_key_exists('tempMorning', $request->all()) ? $request['tempMorning'] : $monitoring->tuberTemperatureMorning,
                'tuberTemperatureEvening' => array_key_exists('tempEvening', $request->all()) ? $request['tempEvening'] : $monitoring->tuberTemperatureEvening,
                'burtAboveTemperature' => array_key_exists('tempAboveBurt', $request->all()) ? $request['tempAboveBurt'] : $monitoring->burtAboveTemperature,
                'humidity' => array_key_exists('humidity', $request->all()) ? $request['humidity'] : $monitoring->humidity,
                'condensate' => boolval($request['condensate']),
                'comment' => $monitoring->comment . ' ' . $request['comment']
            ]

        );
        if ($request['timeUp'] <> null && $request['timeDown'] <> null) {
            StorageMode::create([
                'timeUp' => $request['timeUp'],
                'timeDown' => $request['timeDown'],
                'product_monitoring_id' => $monitoring->id,
            ]);
        }
        return redirect()->route('monitoring.show.filial.all', ['storage_name_id' => $monitoring->storage_name_id, 'harvest_year_id' => $monitoring->harvest_year_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductMonitoring $monitoring)
    {
        $monitoring->delete();
        return response()->json(['status' => true, "redirect_url" => url(route('monitoring.show.filial.all', ['storage_name_id' => $monitoring->storage_name_id, 'harvest_year_id' => $monitoring->harvest_year_id]))]);

    }

    public function showFilial($filial_id, $harvest_year_id)
    {

        $monitoring = ProductMonitoring::query()
                ->with('storageName')
                ->where('harvest_year_id', $harvest_year_id)
                ->get()
                ->where('storageName.filial_id', $filial_id)
                ->unique('storage_name_id')
                ->sortBy('storageName.name')
        ;


        return view('production_monitoring.show_filial', ['monitoring' => $monitoring]);
    }

    public function showFilialMonitoring($storage_id, $harvest_year_id)
    {

        $var = ProductMonitoring::query()
            ->where('storage_name_id', $storage_id)
            ->where('harvest_year_id', $harvest_year_id)
            ->orderBy('date', 'desc')
            ->paginate(25);
        if ($var->isNotEmpty()) {
            return view('production_monitoring.show_filial_monitoring', ['monitoring' => $var]);
        } else {
            return redirect()->route('monitoring.index');
        }


    }
}
