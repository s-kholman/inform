<?php

namespace App\Http\Controllers;

use App\Models\Szr;
use App\Models\Nomenklature;
use App\Models\SzrClasses;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;

class SzrController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:destroy, App\Models\svyaz')->only('destroy', 'update');
        $this->middleware('auth')->except('index');
    }

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
      'title' => 'Справочник - СЗР',
      'label' => 'Введите название СЗР',
      'parent' => 'Класификация СЗР',
      'route' => 'szr',
      'parrent_name' => 'szrClasses'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Szr::orderby('szr_classes_id', 'DESC')->orderby('name')->get();
        $parrent_value = SzrClasses::orderby('name')->get();

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

        if (Szr::where('name', 'ILIKE', '%'.$validated['name'].'%')->count() < 1)
        {
            Szr::Create([
                'name' => $validated['name'],
                'szr_classes_id' => $validated['select']
                ]);
        }



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
        $parrent_value = SzrClasses::orderby('name')->get();

        return view('crud.two_edit', ['const' => self::TITLE, 'value'=>$szr, 'parent_value'=>$parrent_value]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Szr $szr)
    {
        $validated = $request->validate(self::ADD_VALIDATOR_EDIT, self::ERROR_MESSAGES);
        $szr->update([
            'name' => $validated['name'],
            'szr_classes_id' => $validated['select']
        ]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Szr $szr)
    {
        try {
            $szr->delete();
        } catch (\Illuminate\Database\QueryException $e){

        }

        return redirect()->route(self::TITLE['route'].'.index');
    }
}
