<?php

namespace App\Http\Controllers;

use App\Models\filial;
use Illuminate\Http\Request;

class FilialController extends Controller
{
    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов'
    ];

    private const ADD_VALIDATOR = [
        'name' => 'required|max:255',
    ];
    private const TITLE = [
        'title' => 'Справочник - Филиалы',
        'label' => 'Введите название филиала',
        'error' => 'filial',
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, filial $filial)
    {
        $validated = $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);
        $filial->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(filial $filial)
    {
        $filial->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
