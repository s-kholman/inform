<?php

namespace App\Http\Controllers;

use App\Http\Requests\FactoryGuesRequest;
use App\Models\FactoryGues;
use App\Models\FactoryMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FactoryGuesController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($material)
    {

        $gues = FactoryMaterial::with('gues')->where('id', $material)->get();
        return view('factory.gues.create', ['factory' => $gues, 'specifically' => self::SPECIFICALLY]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FactoryGuesRequest $request)
    {

        $valid = $request->validated();
        $full = Validator::make(
            $request->all(), [
                'full' => 'nullable'
            ]
        );
        $full->after(function ($validator) use ($request, $valid) {
            if (round(
                $valid['mechanical']+
                $valid['land']+
                $valid['rot']+
                $valid['haulm']+
                $valid['sixty']+
                $valid['fifty']+
                $valid['forty']+
                $valid['thirty']+
                $valid['less_thirty']
                ,2) <> 100 ) {
                $validator->errors()->add('full', 'Сумма по полям должна равняться 100, сейчас = ' .                 $valid['mechanical']+
                    $valid['land']+
                    $valid['rot']+
                    $valid['haulm']+
                    $valid['sixty']+
                    $valid['fifty']+
                    $valid['forty']+
                    $valid['thirty']+
                    $valid['less_thirty']);
            }
        });
        $full->validate();

        FactoryGues::UpdateOrCreate([
            'factory_material_id' => $request->factory_material_id,
            ],
            [
            'volume' => $request->volume,
            'mechanical' => $request->mechanical,
            'land' => $request->land,
            'haulm' => $request->haulm,
            'rot' => $request->rot,
            'foreign_object' => boolval($request->foreign_object),
            'another_variety' => boolval($request->another_variety),
            'sixty' => $request->sixty,
            'fifty' => $request->fifty,
            'forty' => $request->forty,
            'thirty' => $request->thirty,
            'less_thirty' => $request->less_thirty
        ]);
        return redirect()->route('material.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(FactoryGues $factoryGues)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FactoryGues $factoryGues)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FactoryGues $factoryGues)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FactoryGues $factoryGues)
    {
        //
    }
}
