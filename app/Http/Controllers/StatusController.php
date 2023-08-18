<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - Статусы устроиства',
        'label' => 'Введите название статуса',
        'route' => 'status'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Status::orderby('name')->get();

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
        Status::create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$status]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(CrudOneRequest $request, Status $status)
    {
        $validated = $request->validated();
        $status->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(Status $status)
    {
        $status->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
