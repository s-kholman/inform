<?php

namespace App\Http\Controllers\ObjectControl;

use App\Http\Controllers\Controller;
use App\Models\ObjectControl\ObjectControlPoint;
use App\Models\ObjectControl\ObjectType;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ObjectControlPointController extends Controller
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
        'title' => 'Справочник - Точки контроля',
        'label' => 'Введите наименование точки контроля',
        'parent' => 'К какому типу относится',
        'route' => 'object_control_point',
        'parent_name' => 'objectType'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $value = ObjectControlPoint::query()
            ->with('objectType')
            ->orderby('name')
            ->get()
            ->sortBy('objectType.name')
        ;

        $parent_value = ObjectType::query()
            ->orderby('name')
            ->get()
        ;

        return response()->view('crud.two_index',
            [
                'const' => self::TITLE,
                'value'=>$value,
                'parent_value'=>$parent_value,
            ]
        );
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
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);

        if (ObjectControlPoint::query()
                ->where('name', 'ILIKE', '%'.$validated['name'].'%')
                ->where('object_type_id', $validated['select'])
                ->count() < 1)
        {

            ObjectControlPoint::query()
                ->create(
                    [
                        'name' => $validated['name'],
                        'filial_id' => $validated['select']
                    ]
                );
        }

        return response()->redirectToRoute(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ObjectControlPoint $object_control_point)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ObjectControlPoint $object_control_point): Response
    {

        $parent_value = ObjectType::query()
            ->orderby('name')
            ->get()
        ;

        $get_name_id = $object_control_point->getFillable();

        return response()->view('crud.two_edit',
            [
                'const' => self::TITLE,
                'value'=>$object_control_point,
                'parent_value'=>$parent_value,
                'name_id' => $get_name_id['1'],
            ]
        );
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(Request $request, ObjectControlPoint $object_control_point): RedirectResponse
    {
        $validated = $request->validate(self::ADD_VALIDATOR_EDIT, self::ERROR_MESSAGES);

        $object_control_point->update(
            [
                'name' => $validated['name'],
                'filial_id' => $validated['select']
            ]
        );

        return response()->redirectToRoute(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(ObjectControlPoint $object_control_point): RedirectResponse
    {
        try {

            $object_control_point->delete();

        } catch (QueryException $e){

        }

        return response()->redirectToRoute(self::TITLE['route'].'.index');
    }
}
