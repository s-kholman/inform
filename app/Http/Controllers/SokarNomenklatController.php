<?php

namespace App\Http\Controllers;

use App\Models\SokarNomenklat;
use Illuminate\Http\Request;

class SokarNomenklatController extends Controller
{
    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов'
    ];

    private const ADD_VALIDATOR = [
        'nomenklat' =>'required|max:255'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sokar.nomenklat');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);
        SokarNomenklat::create(['name'=>$validated['nomenklat']]);
        return redirect('sokarnomenklat');
    }

    /**
     * Display the specified resource.
     */
    public function show(SokarNomenklat $sokarNomenklat)
    {
        return view('sokar.sokarnomenklat_show', ['nomenklat' => $sokarNomenklat]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SokarNomenklat $sokarNomenklat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SokarNomenklat $sokarNomenklat)
    {
        $validated = $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);
        $sokarNomenklat->update(['name' => $validated['nomenklat']]);
        return redirect('sokarnomenklat');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SokarNomenklat $sokarNomenklat)
    {
        $sokarNomenklat->delete();
        return redirect('sokarnomenklat');
    }
}
