<?php

namespace App\Http\Controllers;

use App\Http\Requests\PoleRequest;
use App\Models\filial;
use App\Models\Nomenklature;
use App\Models\Pole;
use App\Models\Reproduktion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Pole::class, 'pole');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pole.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $filials = filial::query()
            ->where('id', Auth::user()->Registration->filial_id)
            ->orderBy('name')
            ->get();

        if (Auth::user()->email == 'sergey@krimm.ru'){
            $filials = filial::query()
                ->orderBy('name')
                ->get();
        }

        return view('pole.create', ['filials' => $filials]);
    }

    /**
     * Store a newly created resource in storagebox.
     */
    public function store(PoleRequest $request)
    {

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images/poliv');
        }
        else {
            $path = null;
        }
        Pole::create([
            'name' => $request['pole'],
            'filial_id' => $request['filial'],
            'path' => $path,
            'poliv' => $request->boolean('checkPoliv')
        ]);

        return redirect()->route('pole.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pole $pole)
    {

        foreach (Nomenklature::all() as $value){
            $nomen_arr [$value->kultura_id] [$value->id] =  $value->name;
        }

        foreach (Reproduktion::all() as $value){
            $reprod_arr [$value->kultura_id] [$value->id] =  $value->name;
        }

        return view('pole.edit', ['pole' => $pole,
            'nomen_arr' => json_encode($nomen_arr, JSON_UNESCAPED_UNICODE),
            'reprod_arr' => json_encode($reprod_arr, JSON_UNESCAPED_UNICODE)]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(PoleRequest $request, Pole $pole)
    {

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images/poliv');

            if ($pole->path<>null){
                Storage::delete($pole->path);
            }

            $pole->update([
                'name' => $request->pole,
                'path' => $path,
                'poliv' => $request->checkPoliv ? true : false
            ]);

        }
        else {
            $pole->update([
                'name' => $request->pole,
                'poliv' => $request->checkPoliv ? true : false
            ]);
        }
        return redirect()->route('pole.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(Pole $pole)
    {


        try {
            $pole->delete();
            if ($pole->path <> null){
                Storage::delete($pole->path);
            }
        }
        catch (QueryException $e)
        {
            return redirect()->route('pole.edit', ['pole' => $pole->id]);
        }


        return redirect()->route('pole.index');
    }
}
