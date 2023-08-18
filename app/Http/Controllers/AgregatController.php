<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\Agregat;
use Illuminate\Http\Request;

class AgregatController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - Агрегатов',
        'label' => 'Введите название посевного агрегата',
        'route' => 'agregat'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Agregat::orderby('name')->get();

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
        Agregat::create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Agregat $agregat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agregat $agregat)
    {
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$agregat]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(CrudOneRequest $request, Agregat $agregat)
    {
        $validated = $request->validated();
        $agregat->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(Agregat $agregat)
    {
        $agregat->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
