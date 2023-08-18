<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\filial;
use Illuminate\Http\Request;

class FilialController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - Филиалы',
        'label' => 'Введите название филиала',
        'route' => 'filial'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = filial::orderby('name')->get();

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
        filial::create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(filial $filial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(filial $filial)
    {
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$filial]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(CrudOneRequest $request, filial $filial)
    {
        $validated = $request->validated();
        $filial->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(filial $filial)
    {
        $filial->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
