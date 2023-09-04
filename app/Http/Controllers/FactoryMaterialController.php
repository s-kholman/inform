<?php

namespace App\Http\Controllers;

use App\Actions\factory\material\FactoryMaterialCreateAction;
use App\Actions\factory\material\FactoryMaterialIndexAction;
use App\Http\Requests\FactoryMaterialRequest;
use App\Models\FactoryMaterial;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FactoryMaterialController extends Controller
{
    const SPECIFICALLY = [
        'mechanical' => 10,
        'land' => 15,
        'rot' => 5,
        'haulm' => 1
    ];
    /**
     * Display a listing of the resource.
     */
    public function index(FactoryMaterialIndexAction $factoryMaterialIndexAction)
    {

        return view('factory.material.index', ['materials' => $factoryMaterialIndexAction(), 'specifically' => self::SPECIFICALLY]);
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

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images/factory');
        } else {
            $path = null;
        }

        FactoryMaterial::create([
            'date' => $request['date'],
            'filial_id' => $request['filial_name'],
            'fio' => $request['fio'],
            'nomenklature_id' => $request['nomenklature'],
            'photo_path' => $path,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('material.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(FactoryMaterial $material)
    {
        $gues = $material->with('gues')->where('id', $material->id)->get();
        return view('factory.material.show', ['material' => $gues, 'specifically' => self::SPECIFICALLY]);
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
    public function destroy(FactoryMaterial $material)
    {
        try {
            $material->delete();
            if ($material->photo_path <> null) {
                Storage::delete($material->photo_path);
            }
        } catch (QueryException $e) {
            return redirect()->route('material.index');
        }
        return redirect()->route('material.index');

    }
}
