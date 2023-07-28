<?php

namespace App\Http\Controllers;

use App\Models\Nomenklature;
use Illuminate\Http\Request;

class NomenklatureController extends Controller
{
    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'numeric' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов'
    ];

    private const ADD_VALIDATOR = [
        'nomenklature' => 'required|max:255',
        'kultura' => 'required|numeric'
    ];
    private const TITLE = [
        'title' => 'Справочник - Номенклатура',
        'label' => 'Введите название номенклатуы',
        'error' => 'nomenklature',
        'route' => 'nomenklature'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Nomenklature::orderby('name')->get();

        return view('crud.two_index', ['const' => self::TITLE, 'value'=>$value]);
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

        Nomenklature::create([
            'name' => $validated['nomenklature'],
            'kultura_id' => $validated['kultura']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Nomenklature $nomenklature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nomenklature $nomenklature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nomenklature $nomenklature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nomenklature $nomenklature)
    {
        //
    }
}
