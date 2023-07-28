<?php

namespace App\Http\Controllers;

use App\Models\SokarFIO;
use Illuminate\Http\Request;

class SokarFIOController extends Controller
{
    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'numeric' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов'
    ];

    private const ADD_VALIDATOR = [
        'last' => 'required|max:255',
        'first' => 'required|max:255',
        'middle' => 'nullable|max:255',
        'gender' => 'numeric',
        'sizeShoes' => 'nullable|numeric',
        'sizeClothes' => 'nullable|numeric',
        'sizeHeight' => 'nullable|numeric'

    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sokar.sokarfio');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'd';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);

        $size = json_encode(['shoes' => $request->sizeShoes, 'clothes' => $request->sizeClothes, 'height' => $request->sizeHeight]);

        SokarFIO::create([
            'last' => $request->last,
            'first'=> $request->first,
            'middle'=> $request->middle,
            'gender'=> $request->boolean('gender'),
            'size'=> $size,
            'active'=>false
        ]);

        return redirect()->route('sokarfio.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SokarFIO $sokarfio)
    {
       // return view('test', ['request' => $sokarfio]);
        return view('sokar.fio_show', ['fio' => $sokarfio]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SokarFIO $sokarFIO)
    {
        return 'd';
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SokarFIO $sokarFIO)
    {
        return 'd';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SokarFIO $sokarFIO)
    {
        return 'd';
    }
}
