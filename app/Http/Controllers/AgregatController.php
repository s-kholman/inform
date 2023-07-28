<?php

namespace App\Http\Controllers;

use App\Models\Agregat;
use Illuminate\Http\Request;

class AgregatController extends Controller
{
    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов'
    ];

    private const ADD_VALIDATOR = [
        'name' => 'required|max:255',
    ];
    private const TITLE = [
        'title' => 'Справочник - Агрегатов',
        'label' => 'Введите название посевного агрегата',
        'error' => 'agregat',
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agregat $agregat)
    {
        $validated = $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);
        $agregat->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agregat $agregat)
    {
        $agregat->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
