<?php

namespace App\Http\Controllers;

use App\Models\filial;
use App\Models\PeatExtraction;
use Illuminate\Http\Request;

class PeatExtractionController extends Controller
{
    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'numeric' => 'Выберите из списка',
        'max' => 'Значение не должно быть длинне :max символов',
        'unique' => 'Значение не уникально'
    ];

    private const ADD_VALIDATOR_EDIT = [
        'name' => 'required|max:255',
        'select' => 'numeric'
    ];

    private const ADD_VALIDATOR = [
        'name' => 'required|max:255|unique:peat_extractions,name',
        'select' => 'numeric'
    ];
    private const TITLE = [
        'title' => 'Справочник - Место добычи торфа',
        'label' => 'Введите название места добычи торфа',
        'parent' => 'К какому филиалу относится',
        'route' => 'extraction',
        'parent_name' => 'filial'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = PeatExtraction::query()->with('filial')->orderby('filial_id', 'DESC')->orderby('name')->get();
        $parent_value = filial::orderby('name')->get();

        return view('crud.two_index', ['const' => self::TITLE, 'value'=>$value, 'parent_value'=>$parent_value]);
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
    public function store(Request $request)
    {
        $validated = $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);
        if (PeatExtraction::where('name', 'ILIKE', '%'.$validated['name'].'%')->count() < 1)
        {
            PeatExtraction::query()->create([
                'name' => $validated['name'],
                'filial_id' => $validated['select']
            ]);
        }
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PeatExtraction $extraction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PeatExtraction $extraction)
    {
        $parent_value = filial::orderby('name')->get();
        $get_name_id = $extraction->getFillable();
        return view('crud.two_edit', ['const' => self::TITLE, 'value'=>$extraction, 'parent_value'=>$parent_value, 'name_id' => $get_name_id['1']]);

    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(Request $request, PeatExtraction $extraction)
    {
        $validated = $request->validate(self::ADD_VALIDATOR_EDIT, self::ERROR_MESSAGES);
        $extraction->update([
            'name' => $validated['name'],
            'filial_id' => $validated['select']
        ]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(PeatExtraction $extraction)
    {
        try {
            $extraction->delete();
        } catch (\Illuminate\Database\QueryException $e){
        }
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
