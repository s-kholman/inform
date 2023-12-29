<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\Machine;

class MachineController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - Агрегат',
        'label' => 'Введите наименование посевного агрегата',
        'route' => 'machine'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Machine::query()->orderby('name')->get();

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
        Machine::query()->create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Machine $machine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Machine $machine)
    {
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$machine]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(CrudOneRequest $request, Machine $machine)
    {
        $validated = $request->validated();
        $machine->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(Machine $machine)
    {
        $machine->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
