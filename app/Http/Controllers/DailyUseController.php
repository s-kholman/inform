<?php

namespace App\Http\Controllers;

use App\Jobs\DailyUseOne;
use App\Models\CurrentStatus;
use App\Models\DailyUse;
use Illuminate\Http\Request;

class DailyUseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = CurrentStatus::with('status')->get();
        if($status->isNotEmpty())
        {
            $device = $status->
            sortByDesc('date')->
            sortByDesc('id')->
            unique(['device_id'])->
            sortBy('filial.name')->
            whereNotIn('status.active', false);
            foreach ($device as $value){
                dispatch(new DailyUseOne($value));
            }
        }
    }

    /**
     * Store a newly created resource in storagebox.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyUse $dailyUse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyUse $dailyUse)
    {
        //
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(Request $request, DailyUse $dailyUse)
    {
        //
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(DailyUse $dailyUse)
    {
        //
    }
}
