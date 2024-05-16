<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\TypeFieldWork;

class TypeFieldWorkController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - Тип посевных работ',
        'label' => 'Введите наименование',
        'route' => 'type_field_work'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = TypeFieldWork::query()->orderby('name')->get();

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
        TypeFieldWork::query()
            ->create([
                'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeFieldWork $typeFieldWork)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeFieldWork $typeFieldWork)
    {
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$typeFieldWork]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CrudOneRequest $request, TypeFieldWork $typeFieldWork)
    {
        $validated = $request->validated();
        $typeFieldWork->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeFieldWork $typeFieldWork)
    {
        $typeFieldWork->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
