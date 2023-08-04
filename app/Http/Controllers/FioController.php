<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\Fio;
use Illuminate\Http\Request;

class FioController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - ФИО',
        'label' => 'Введите - ФИО',
        'route' => 'fio'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Fio::orderby('name')->get();

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
     * Store a newly created resource in storage.
     */
    public function store(CrudOneRequest $request)
    {
        $validated = $request->validated();
        Fio::create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fio $fio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fio $fio)
    {
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$fio]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CrudOneRequest $request, Fio $fio)
    {
        $validated = $request->validated();
        $fio->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fio $fio)
    {
        $fio->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
