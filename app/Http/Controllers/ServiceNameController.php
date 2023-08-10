<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\ServiceName;
use Illuminate\Http\Request;

class ServiceNameController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - Виды ремонта/работ',
        'label' => 'Введите название ремонта/работ',
        'route' => 'service_name'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = ServiceName::orderby('name')->get();

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
        ServiceName::create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceName $serviceName)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceName $serviceName)
    {
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$serviceName]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CrudOneRequest $request, ServiceName $serviceName)
    {
        $validated = $request->validated();
        $serviceName->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceName $serviceName)
    {
        $serviceName->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
