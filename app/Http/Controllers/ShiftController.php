<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\Shift;


class ShiftController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - Смены',
        'label' => 'Введите название смены',
        'route' => 'shift'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Shift::query()->orderby('name')->get();

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
        Shift::create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $agregat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$shift]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(CrudOneRequest $request, Shift $shift)
    {
        $validated = $request->validated();
        $shift->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(Shift $shift)
    {
        $shift->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
