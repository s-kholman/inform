<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\Brend;
use Illuminate\Http\Request;

class BrendController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - Бренды',
        'label' => 'Введите название бренда',
        'route' => 'brend'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Brend::orderby('name')->get();

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
        Brend::create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brend $brend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brend $brend)
    {
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$brend]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CrudOneRequest $request, Brend $brend)
    {
        $validated = $request->validated();
        $brend->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brend $brend)
    {
        $brend->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
