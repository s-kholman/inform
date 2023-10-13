<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductMonitoringRequest;
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
    public function index()
    {
        $var = ProductMonitoring::with('storageName')->get();
        $sort = $var->groupBy('storageName.filial_id')->keys();
        return view('production_monitoring.index', ['sort' => $sort]);
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
    public function store(ProductMonitoringRequest $request)
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
                'comment' => $request['comment'],
            ]
        );
        if ($request['timeUp'] <> null && $request['timeDown'] <> null) {
            StorageMode::create([
                'timeUp' => $request['timeUp'],
                'timeDown' => $request['timeDown'],
                'product_monitoring_id' => $date->id,
            ]);
        }
        return redirect()->route('monitoring.show.filial.all', ['id' => $request['storage']]);
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
    public function update(Request $request, ProductMonitoring $monitoring)
    {

        ProductMonitoring::where('id', $monitoring->id)->
        update(
            [
                'burtTemperature' => array_key_exists('tempBurt', $request->all()) ? $request['tempBurt'] : $monitoring->burtTemperature,
                'tuberTemperatureMorning' => array_key_exists('tempMorning', $request->all()) ? $request['tempMorning'] : $monitoring->tuberTemperatureMorning,
                'tuberTemperatureEvening' => array_key_exists('tempEvening', $request->all()) ? $request['tempEvening'] : $monitoring->tuberTemperatureEvening,
                'burtAboveTemperature' => array_key_exists('tempAboveBurt', $request->all()) ? $request['tempAboveBurt'] : $monitoring->burtAboveTemperature,
                'humidity' => array_key_exists('humidity', $request->all()) ? $request['humidity'] : $monitoring->humidity,
                'comment' => $monitoring->comment .' '. $request['comment']
            ]

        );
        if ($request['timeUp'] <> null && $request['timeDown'] <> null){
            StorageMode::create([
                'timeUp' => $request['timeUp'],
                'timeDown' => $request['timeDown'],
                'product_monitoring_id' => $monitoring->id,
            ]);
        }
        return redirect()->route('monitoring.show.filial.all', ['id' => $monitoring->storage_name_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductMonitoring $monitoring)
    {
        $monitoring->delete();
        return redirect()->route('monitoring.index');
    }

    public function showFilial($id)
    {
        $var = ProductMonitoring::with('storageName')->get();
        $monitoring = $var->where('storageName.filial_id', $id)->unique('storage_name_id');
        return view('production_monitoring.show_filial', ['monitoring' => $monitoring]);
    }

    public function showFilialMonitoring ($id)
    {
        $var = ProductMonitoring::where('storage_name_id',$id)->get();
        return view('production_monitoring.show_filial_monitoring', ['monitoring' => $var]);
    }
}
