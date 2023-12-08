<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\HarvestYear;


class HarvestYearController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - Год урожая',
        'label' => 'Введите год',
        'route' => 'year'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = HarvestYear::orderby('name')->get();

        return view('crud.one_index', ['const' => self::TITLE, 'value'=>$value]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storagebox.
     */
    public function store(CrudOneRequest $request)
    {
        $validated = $request->validated();
        HarvestYear::create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(HarvestYear $harvestYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HarvestYear $year)
    {
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$year]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(CrudOneRequest $request, HarvestYear $year)
    {
        $validated = $request->validated();
        $year->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(HarvestYear $year)
    {
        $year->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
