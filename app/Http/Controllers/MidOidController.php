<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Http\Requests\MidOidRequest;
use App\Models\MibOid;
use Illuminate\Http\Request;

class MidOidController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - Mid Oid',
        'label' => 'Введите Mid Oid',
        'route' => 'mibOid'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = MibOid::orderby('name')->get();

        return view('Printer.miboid.index', ['const' => self::TITLE, 'value'=>$value]);
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
    public function store(MidOidRequest $request)
    {

        $validated = $request->validated();
        MibOid::create([
            'name' => $validated['name'],
            'comment' => $validated['comment']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(MibOid $mibOid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MibOid $mibOid)
    {
        return view('Printer.miboid.edit', ['const' => self::TITLE, 'value'=>$mibOid]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(MidOidRequest $request, MibOid $mibOid)
    {
        $validated = $request->validated();
        $mibOid->update([
            'name' => $validated['name'],
            'comment' => $validated['comment']
        ]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(MibOid $mibOid)
    {
        //
    }
}
