<?php

namespace App\Http\Controllers;

use App\Models\CurrentStatus;
use App\Models\DailyUse;
use App\Models\Service;
use Illuminate\Http\Request;

class CurrentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $service_get = Service::select('device_id', 'service_names_id', 'filial_id', 'date')->where('device_id', $id)->orderby('date')->get();
        $status_get = CurrentStatus::select('device_id', 'status_id', 'filial_id', 'date')->where('device_id', $id)->orderby('date')->get();
        if ($status_get->isNotEmpty()) {
            foreach ($status_get as $value) {
                $status [] = [
                    'filial' => $value->filial->name,
                    'Name' => $value->status->name,
                    'date' => $value->date,
                    'count' => DailyUse::where('device_id', $id)->where('date', '<=', $value->date)->latest('date')->take(1)->value('count')
                ];
            }
        } else {
            $status = [];
        }
        if ($service_get->isNotEmpty()) {
            foreach ($service_get as $value) {
                $service [] = [
                    'filial' => $value->filial->name,
                    'Name' => $value->ServiceName->name,
                    'date' => $value->date,
                    'count' => DailyUse::where('device_id', $id)->where('date', '<=', $value->date)->latest('date')->take(1)->value('count')
                ];
            }
        } else {
            $service = [];
        }
        $merded = collect($status)->merge(collect($service))->sortBy('date');

        return view('printer.current.show', ['service' => $merded]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CurrentStatus $currentStatus)
    {
        return view('printer.current.edit', ['currentStatus' => $currentStatus]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CurrentStatus $currentStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CurrentStatus $currentStatus)
    {
        //
    }
}
