<?php

namespace App\Http\Controllers;

use App\Models\Brend;
use App\Models\DeviceName;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class DeviceNameController extends Controller
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
        'name' => 'required|max:255|unique:device_names,name',
        'select' => 'numeric'
    ];
    private const TITLE = [
        'title' => 'Справочник - Модели',
        'label' => 'Введите название модели',
        'parent' => 'Выберите бренд',
        'route' => 'device_name',
        'parent_name' => 'brend'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = DeviceName::query()->with('brend')->orderby('brend_id', 'DESC')->orderby('name')->get();
        $parent_value = Brend::orderby('name')->get();

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
        if (DeviceName::where('name', 'ILIKE', '%'.$validated['name'].'%')->count() < 1)
        {
            DeviceName::Create([
                'name' => $validated['name'],
                'brend_id' => $validated['select']
            ]);
        }
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(DeviceName $deviceName)
    {
        return 'show';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeviceName $deviceName)
    {
        $parent_value = Brend::orderby('name')->get();
        $get_name_id = $deviceName->getFillable();
        return view('Printer.edit', ['const' => self::TITLE, 'value'=>$deviceName, 'parent_value'=>$parent_value, 'name_id' => $get_name_id['1']]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(Request $request, DeviceName $deviceName)
    {
        $validated = $request->validate(self::ADD_VALIDATOR_EDIT, self::ERROR_MESSAGES);
        $deviceName->update([
            'name' => $validated['name'],
            'brend_id' => $validated['select']
        ]);
        if (isEmpty($request->input('midoid'))){
            $deviceName->miboid()->sync($request->input('midoid'));
        }
            return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(DeviceName $deviceName)
    {
        try {
            $deviceName->delete();
        } catch (\Illuminate\Database\QueryException $e){
        }
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
