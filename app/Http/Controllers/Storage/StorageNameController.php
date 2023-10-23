<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrudOneRequest;
use App\Models\filial;
use App\Models\StorageName;
use Illuminate\Http\Request;

class StorageNameController extends Controller
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
        'title' => 'Справочник - Склады - Места хранения',
        'label' => 'Введите наименование склада / места хранения',
        'parent' => 'К какому филиалу относится',
        'route' => 'storagename',
        'parrent_name' => 'filial'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = StorageName::orderby('filial_id', 'DESC')->orderby('name')->get();
        $parrent_value = filial::orderby('name')->get();

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
     * Store a newly created resource in storagebox.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);
        if (StorageName::query()
                ->where('name', 'ILIKE', '%'.$validated['name'].'%')
                ->where('filial_id', $validated['select'])
                ->count() < 1)
        {
            StorageName::Create([
                'name' => $validated['name'],
                'filial_id' => $validated['select']
            ]);
        }
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(StorageName $box)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StorageName $storagename)
    {

        $parrent_value = filial::orderby('name')->get();
        $get_name_id = $storagename->getFillable();
        return view('crud.two_edit', ['const' => self::TITLE, 'value'=>$storagename, 'parent_value'=>$parrent_value, 'name_id' => $get_name_id['1']]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(Request $request, StorageName $storagename)
    {
        $validated = $request->validate(self::ADD_VALIDATOR_EDIT, self::ERROR_MESSAGES);
        $storagename->update([
            'name' => $validated['name'],
            'filial_id' => $validated['select']
        ]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(StorageName $storagename)
    {
        try {
            $storagename->delete();
        } catch (\Illuminate\Database\QueryException $e){
        }
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
