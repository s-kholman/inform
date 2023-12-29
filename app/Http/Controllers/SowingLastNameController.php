<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\SowingLastName;

class SowingLastNameController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - ФИО',
        'label' => 'Введите ФИО',
        'route' => 'sowingLastName'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = SowingLastName::query()->orderby('name')->get();

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
     * Store a newly created resource in storagebox.
     */
    public function store(CrudOneRequest $request)
    {
        $validated = $request->validated();
        SowingLastName::query()->create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SowingLastName $sowingLastName)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SowingLastName $sowingLastName)
    {
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$sowingLastName]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(CrudOneRequest $request, SowingLastName $sowingLastName)
    {
        $validated = $request->validated();
        $sowingLastName->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(SowingLastName $sowingLastName)
    {
        $sowingLastName->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
