<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    private const SIZE_TYPE = [
      'shoe' => ['type' => 0, 'name' => 'Размер обуви'], //Размер обуви
      'body' => ['type' => 1, 'name' => 'Рост'], //Рост
      'head' => ['type' => 2, 'name' => 'Размер одежды'], //Размер одежды
    ];
    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов'
    ];

    private const ADD_VALIDATOR = [
        'size' => 'required|max:255',
        'size_type' => 'required|numeric'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sokar.size', ['size_type' => self::SIZE_TYPE]);
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
        Size::create([
            'name'=>$validated['size'],
            'size_type' => $validated['size_type']
        ]);
        return redirect('size');
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        return view('sokar.size_show', ['size' => $size , 'size_type' => self::SIZE_TYPE]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {
       // return view('test', ['request' => $request]);
        $validated = $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);
        $size->update([
            'name' => $validated['size'],
            'size_type' => $validated['size_type']
        ]);
        return redirect('size');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        $size->delete();
        return redirect('size');
    }
}
