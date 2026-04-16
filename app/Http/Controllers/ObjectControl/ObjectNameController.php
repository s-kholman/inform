<?php

namespace App\Http\Controllers\ObjectControl;

use App\Http\Controllers\Controller;
use App\Http\Requests\ObjectControlNameRequest;
use App\Models\filial;
use App\Models\ObjectControl\ObjectName;
use App\Models\ObjectControl\ObjectType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ObjectNameController extends Controller
{
    public function index(): Response
    {

        $filials = filial::query()
            ->with('Pole')
            ->get()
            ->sortBy('name')
            ;

        $objectType = ObjectType::query()
            ->get()
            ;

        return response()->view('objectControl.objectName.index',
            [
                'filials' => $filials,
                'objectType' => $objectType,
            ],
        );
    }

    public function store(ObjectControlNameRequest $controlNameRequest): RedirectResponse
    {

        ObjectName::query()
            ->create(
                [
                    'name' => $controlNameRequest->name,
                    'filial_id' => $controlNameRequest->filial,
                    'object_type_id' => $controlNameRequest->selectObjectControlType,
                    'pole_id' => $controlNameRequest->pole,
                ]
            );

        return response()->redirectToRoute('object.control.name.index');
    }
}
