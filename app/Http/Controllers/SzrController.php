<?php

namespace App\Http\Controllers;

use App\Models\Szr;
use App\Models\Nomenklature;
use Illuminate\Http\Request;

class SzrController extends Controller
{
    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов'
    ];

    private const ADD_VALIDATOR = [
        'name' => 'required|max:255',
    ];
    private const TITLE = [
      'title' => 'Справочник - СЗР',
      'label' => 'Введите название СЗР',
      'error' => 'szr',
      'route' => 'szr'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Szr::orderby('name')->get();

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
        Szr::create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
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
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$szr]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Szr $szr)
    {
        $validated = $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);
        $szr->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Szr $szr)
    {
        $szr->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
