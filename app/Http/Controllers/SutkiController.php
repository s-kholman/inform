<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\Sutki;
use Illuminate\Http\Request;

class SutkiController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - Периуды суток',
        'label' => 'Введите название периуд',
        'route' => 'sutki'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Sutki::orderby('name')->get();

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
        Sutki::create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sutki $sutki)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sutki $sutki)
    {
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$sutki]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CrudOneRequest $request, Sutki $sutki)
    {
        $validated = $request->validated();
        $sutki->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sutki $sutki)
    {
        $sutki->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
