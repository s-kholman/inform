<?php

namespace App\Http\Controllers;

use App\Actions\factory\material\CreateAction;
use App\Actions\factory\material\FactoryMaterialCreateAction;
use App\Actions\factory\material\FactoryMaterialIndexAction;
use App\Http\Requests\FactoryMaterialRequest;
use App\Models\FactoryMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactoryMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FactoryMaterialIndexAction $factoryMaterialIndexAction)
    {
        return view('factory.material.index', ['materials' => $factoryMaterialIndexAction()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(FactoryMaterialCreateAction $factoryMaterialCreateAction)
    {
        return view('factory.material.create', ['filials' => $factoryMaterialCreateAction()[0], 'nomenklatures' => $factoryMaterialCreateAction()[1]]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FactoryMaterialRequest $request)
    {
        FactoryMaterial::create([
            'date' => $request['date'],
            'filial_id' => $request['filial_name'],
            'fio' => $request['fio'],
            'volume' => $request['volume'],
            'nomenklature_id' => $request['nomenklature'],
            'photo_path' => null,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('material.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(FactoryMaterial $factoryMaterial)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FactoryMaterial $factoryMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FactoryMaterial $factoryMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FactoryMaterial $factoryMaterial)
    {
        //
    }
}
