<?php

namespace App\Http\Controllers;

use App\Models\SokarSklad;
use App\Models\SokarSpisanie;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SokarSkladController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sklad_get = SokarSklad::where('count', '>', 0)->get();
        $sklad = [];
        foreach ($sklad_get as $value){
            $add_arr = $value->count - SokarSpisanie::where('sokar_sklad_id', $value->id)->get()->sum('count');
            $value->count = $add_arr;
            if ($add_arr){
                $sklad [] = $value;
            }
        }
        return view('sokar.sklad', ['arr' => $sklad]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view('test', ['request' => SokarSklad::select('counterpartie_id', 'sokar_nomenklat_id')->whereDate('created_at', Carbon::today())->groupby('sokar_sklads.counterpartie_id')->get()]);
        return view('sokar.sklad_create');
    }

    /**
     * Store a newly created resource in storagebox.
     */
    public function store(Request $request)
    {
        SokarSklad::create([
            'sokar_nomenklat_id' => $request->nomenklat,
            'size_id' => $request->size,
            'color_id' => $request->color,
            'size_height' => $request->height,
            'count' => $request->count,
            'date' => $request->date,
            'counterpartie_id' => $request->counterparty,
        ]);

        return redirect('sokarsklad');
    }

    /**
     * Display the specified resource.
     */
    public function show(SokarSklad $sokarSklad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SokarSklad $sokarSklad)
    {
        //
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(Request $request, SokarSklad $sokarSklad)
    {
        //
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(SokarSklad $sokarSklad)
    {
        //
    }
}
