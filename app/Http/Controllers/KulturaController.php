<?php

namespace App\Http\Controllers;

use App\Models\Kultura;
use App\Models\Vidposeva;
use Illuminate\Http\Request;

class KulturaController extends Controller
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
        'name' => 'required|max:255|unique:szrs,name',
        'select' => 'numeric'
    ];
    private const TITLE = [
        'title' => 'Справочник - Культура',
        'label' => 'Введите название культуры',
        'parent' => 'Вид посева',
        'route' => 'kultura',
        'parent_name' => 'vidposeva'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Kultura::query()->with('Vidposeva')->orderby('vidposeva_id', 'DESC')->orderby('name')->get();
        $parent_value = Vidposeva::orderby('name')->get();

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
        if (Kultura::where('name', 'ILIKE', '%'.$validated['name'].'%')->count() < 1)
        {
            Kultura::Create([
                'name' => $validated['name'],
                'vidposeva_id' => $validated['select']
            ]);
        }
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kultura $kultura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kultura $kultura)
    {
        $parent_value = Vidposeva::orderby('name')->get();
        $get_name_id = $kultura->getFillable();
        return view('crud.two_edit', ['const' => self::TITLE, 'value'=>$kultura, 'parent_value'=>$parent_value, 'name_id' => $get_name_id['1']]);

    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(Request $request, Kultura $kultura)
    {
        $validated = $request->validate(self::ADD_VALIDATOR_EDIT, self::ERROR_MESSAGES);
        $kultura->update([
            'name' => $validated['name'],
            'vidposeva_id' => $validated['select']
        ]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(Kultura $kultura)
    {
        try {
            $kultura->delete();
        } catch (\Illuminate\Database\QueryException $e){
        }
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
