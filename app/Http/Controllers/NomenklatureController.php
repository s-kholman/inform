<?php

namespace App\Http\Controllers;

use App\Models\Kultura;
use App\Models\Nomenklature;
use Illuminate\Http\Request;

class NomenklatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:destroy, App\Models\svyaz')->only('destroy', 'update');
        $this->middleware('auth')->except('index');
    }

    private const ADD_VALIDATOR_EDIT = [
        'name' => 'required|max:255',
        'select' => 'numeric'
    ];

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
        'parent_name' => 'kultura'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Nomenklature::query()->with('Kultura')->orderby('kultura_id', 'DESC')->orderby('name')->get();
        $parent_value = Kultura::orderby('name')->get();

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

        Nomenklature::create([
            'name' => $validated['name'],
            'kultura_id' => $validated['select']
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
        $parent_value = Kultura::orderby('name')->get();
        $get_name_id = $nomenklature->getFillable();
        return view('crud.two_edit', ['const' => self::TITLE, 'value'=>$nomenklature, 'parent_value'=>$parent_value, 'name_id' => $get_name_id['1']]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(Request $request, Nomenklature $nomenklature)
    {
        $validated = $request->validate(self::ADD_VALIDATOR_EDIT, self::ERROR_MESSAGES);
        $nomenklature->update([
            'name' => $validated['name'],
            'vidposeva_id' => $validated['select']
        ]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(Nomenklature $nomenklature)
    {
        try {
            $nomenklature->delete();
        } catch (\Illuminate\Database\QueryException $e){
        }
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
