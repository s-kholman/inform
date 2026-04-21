<?php

namespace App\Http\Controllers\ObjectControl;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrudOneRequest;
use App\Models\ObjectControl\ObjectControlPoint;
use App\Models\ObjectControl\ObjectType;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class ObjectTypeController extends Controller
{
    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'numeric' => 'Выберите из списка',
        'max' => 'Значение не должно быть длиннее :max символов',
        'unique' => 'Значение не уникально'
    ];

    private const ADD_VALIDATOR_EDIT = [
        'name' => 'required|max:255',
        'select' => 'numeric'
    ];

    private const ADD_VALIDATOR = [
        'name' => 'required|max:255|unique:object_types,name',
        'select' => 'numeric'
    ];
    private const TITLE = [
        'title' => 'Справочник - Тип контроля',
        'label' => 'Введите наименование тип контроля',
        'parent' => 'К какой роли оповещения отнести',
        'route' => 'object_control_type',
        'parent_name' => 'Role'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $value = ObjectType::query()
            ->with('Role')
            ->orderby('name')
            ->get()
            ->sortBy('Role.name')
        ;

        $parent_value = Role::query()
            ->select(['description as name', 'id'])
            ->where('name', 'LIKE', 'ControlObject%')
            ->whereNotNull('description')
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

        if (ObjectType::query()
                ->where('name', 'ILIKE', '%'.$validated['name'].'%')
                ->where('role_id', $validated['select'])
                ->count() < 1)
        {

            ObjectType::query()
                ->create(
                    [
                        'name' => $validated['name'],
                        'role_id' => $validated['select']
                    ]
                );
        }

        return response()->redirectToRoute(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ObjectType $objectType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ObjectType $object_control_type): Response
    {

        $parent_value = Role::query()
            ->select(['description as name', 'id'])
            ->where('name', 'LIKE', 'ControlObject%')
            ->whereNotNull('description')
            ->orderby('name')
            ->get()
        ;

        $get_name_id = $object_control_type->getFillable();

        return response()->view('crud.two_edit',
            [
                'const' => self::TITLE,
                'value'=>$object_control_type,
                'parent_value'=>$parent_value,
                'name_id' => $get_name_id['1'],
            ]
        );
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(Request $request, ObjectType $object_control_type): RedirectResponse
    {
        $validated = $request->validate(self::ADD_VALIDATOR_EDIT, self::ERROR_MESSAGES);

        $object_control_type->update(
            [
                'name' => $validated['name'],
                'role_id' => $validated['select']
            ]
        );

        return response()->redirectToRoute(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(ObjectType $object_control_type): RedirectResponse
    {
        try {

            $object_control_type->delete();

        } catch (QueryException $e){

        }

        return response()->redirectToRoute(self::TITLE['route'].'.index');
    }
}
