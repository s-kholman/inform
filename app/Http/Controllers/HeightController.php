<?php

namespace App\Http\Controllers;

use App\Models\Height;
use Illuminate\Http\Request;

class HeightController extends Controller
{

    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов'
    ];

    private const ADD_VALIDATOR = [
        'height' => 'required|max:255',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sokar.height');
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
        Height::create(['name'=>$validated['height']]);
        return redirect('height');
    }

    /**
     * Display the specified resource.
     */
    public function show(Height $height)
    {
        return view('sokar.height_show', ['height' => $height]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Height $height)
    {
        //
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(Request $request, Height $height)
    {
        $validated = $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);
        $height->update(['name' => $validated['height']]);
        return redirect('height');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(Height $height)
    {
        $height->delete();
        return redirect('height');
    }
}
