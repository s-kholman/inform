<?php

namespace App\Http\Controllers\ObjectControl;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrudOneRequest;
use App\Models\ObjectControl\ObjectType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ObjectTypeController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - Типы контроля',
        'label' => 'Введите название контроля',
        'route' => 'object_control_type'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $value = ObjectType::query()
            ->orderby('name')
            ->get()
        ;

        return response()->view('crud.one_index',
            [
                'const' => self::TITLE,
                'value'=>$value,
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
    public function store(CrudOneRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        ObjectType::query()
            ->create(
                [
                'name' => $validated['name'],
                ]
            );

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

        return response()->view('crud.one_edit',
            [
                'const' => self::TITLE,
                'value'=>$object_control_type,
            ]
        );
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(CrudOneRequest $request, ObjectType $object_control_type): RedirectResponse
    {
        $validated = $request->validated();

        $object_control_type->update(['name' => $validated['name']]);

        return response()->redirectToRoute(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(ObjectType $object_control_type)
    {
        $object_control_type->delete();

        return response()->redirectToRoute(self::TITLE['route'].'.index');
    }
}
