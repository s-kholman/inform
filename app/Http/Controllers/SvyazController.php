<?php

namespace App\Http\Controllers;

use App\Actions\sowing\svyaz\SvyazStoreAction;
use App\Http\Requests\SvyazRequest;
use App\Models\Fio;
use App\Models\Svyaz;
use Illuminate\Http\Request;

class SvyazController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sowing.svyaz.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $use_fio = svyaz::select('fio_id')->where('active', true)->get();
        $fio = fio::whereNotIn('id', $use_fio)->get();
        return view('sowing.svyaz.create', ['fios' => $fio]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SvyazRequest $request, SvyazStoreAction $svyazStoreAction)
    {
        $svyazStoreAction($request);
        return redirect()->route('svyaz.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Svyaz $svyaz)
    {
        return view('sowing.svyaz.show', ['svyaz' => $svyaz]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Svyaz $svyaz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Svyaz $svyaz)
    {
        $svyaz->update([
            'active' => $request->active
        ]);
        return redirect()->route('svyaz.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Svyaz $svyaz)
    {
        $svyaz->delete();
        return redirect()->route('svyaz.index');
    }
}
