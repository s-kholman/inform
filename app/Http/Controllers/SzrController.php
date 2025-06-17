<?php

namespace App\Http\Controllers;

use App\Http\Requests\SzrRequest;
use App\Models\Szr;
use App\Models\SzrClasses;

class SzrController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:destroy, App\Models\svyaz')->only('destroy', 'update');
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Szr::query()->with('SzrClasses')->orderby('szr_classes_id', 'DESC')->orderby('name')->get();


        return view('szr.index', ['value'=>$value, ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parent_value = SzrClasses::orderby('name')->get();
        return view('szr.create', ['parent_value'=>$parent_value]);
    }

    /**
     * Store a newly created resource in storagebox.
     */
    public function store(SzrRequest $szr)
    {
//        dd($szr->post());

            Szr::Create([
                'name' => $szr->name,
                'szr_classes_id' => $szr->select,
                'interval_day_start' => $szr->interval_day_start,
                'interval_day_end' => $szr->interval_day_end,
                'dosage' => $szr->dosage,
            ]);

        return redirect()->route('szr.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Szr $szr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Szr $szr)
    {
        $parent_value = SzrClasses::orderby('name')->get();
        return view('szr.edit', [ 'szr'=>$szr, 'parent_value' => $parent_value]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(SzrRequest $szrRequest, Szr $szr)
    {

        $szr->update([
            'name' => $szrRequest->name,
            'szr_classes_id' => $szrRequest->select,
            'interval_day_start' => $szrRequest->interval_day_start,
            'interval_day_end' => $szrRequest->interval_day_end,
            'dosage' => $szrRequest->dosage,
        ]);

        return redirect()->route('szr.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(Szr $szr)
    {
        try {
            $szr->delete();
        } catch (\Illuminate\Database\QueryException $e){
        }
        return redirect()->route('szr.index');
    }

    public function getApi($id) {

    }
}
