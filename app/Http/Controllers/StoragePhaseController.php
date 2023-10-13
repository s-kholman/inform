<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\StoragePhase;
use Illuminate\Database\QueryException;

class StoragePhaseController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - Фазы хранения',
        'label' => 'Введите название фаз хранения',
        'route' => 'phase'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = StoragePhase::orderby('name')->get();

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
        StoragePhase::create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(StoragePhase $phase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StoragePhase $phase)
    {
       // dd($storagePhase);
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$phase]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CrudOneRequest $request, StoragePhase $phase)
    {
        $validated = $request->validated();
        $phase->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoragePhase $phase)
    {
        try {
            $phase->delete();
        } catch (QueryException $e){
        }
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
