<?php

namespace App\Http\Controllers;

use App\Models\Kultura;
use App\Models\Nomenklature;
use Illuminate\Http\Request;

class NomenklatureController extends Controller
{
    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'numeric' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов',
        'unique' => 'Значение не уникально'
    ];

    private const ADD_VALIDATOR = [
        'name' => 'required|max:255',
        'select' => 'required|numeric'
    ];
    private const TITLE = [
        'title' => 'Справочник - Номенклатура',
        'label' => 'Введите название номенклатуы',
        'parent' => 'Культура',
        'route' => 'nomenklature',
        'parrent_name' => 'Kultura'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Nomenklature::orderby('kultura_id', 'DESC')->orderby('name')->get();
        $parrent_value = Kultura::orderby('name')->get();

        return view('crud.two_index', ['const' => self::TITLE, 'value'=>$value, 'parrent_value'=>$parrent_value]);

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
