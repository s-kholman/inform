<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoragePhaseTemperaturesRequest;
use App\Models\StoragePhaseTemperature;
use Illuminate\Http\Request;

class StoragePhaseTemperatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('production_monitoring.storagePhaseTemperatures.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('production_monitoring.storagePhaseTemperatures.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoragePhaseTemperaturesRequest $request)
    {
        StoragePhaseTemperature::query()
            ->updateOrCreate(
                [
                    'storage_phase_id' => $request['storage_phase_id']
                ],
                $request->validated()
            );

        return redirect()->route('temperatures.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(StoragePhaseTemperature $storagePhaseTemperature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StoragePhaseTemperature $storagePhaseTemperature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StoragePhaseTemperature $storagePhaseTemperature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoragePhaseTemperature $storagePhaseTemperature)
    {
        //
    }
}
