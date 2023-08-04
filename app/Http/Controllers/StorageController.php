<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\Storage;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - Склады',
        'label' => 'Введите название Склада',
        'route' => 'box'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Storage::orderby('name')->get();

        return view('crud.one_index', ['const' => self::TITLE, 'value'=>$value]);
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
    public function store(CrudOneRequest $request)
    {
        $validated = $request->validated();
        Storage::create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Storage $box)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Storage $box)
    {
//        return view('test', ['request' => $storage]);
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$box]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CrudOneRequest $request, Storage $box)
    {
        $validated = $request->validated();
        $box->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Storage $box)
    {
        $box->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
