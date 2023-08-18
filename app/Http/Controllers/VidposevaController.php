<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\Vidposeva;
use Illuminate\Http\Request;

class VidposevaController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - Вид посева',
        'label' => 'Введите название филиала',
        'route' => 'vidposeva'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Vidposeva::orderby('name')->get();

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
        Vidposeva::create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vidposeva $vidposeva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vidposeva $vidposeva)
    {
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$vidposeva]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(CrudOneRequest $request, Vidposeva $vidposeva)
    {
        $validated = $request->validated();
        $vidposeva->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(Vidposeva $vidposeva)
    {
        $vidposeva->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
