<?php

namespace App\Http\Controllers;

use App\Models\Pole;
use App\Models\Sevooborot;
use App\Models\Spraying;
use App\Models\Szr;
use Illuminate\Http\Request;

class SprayingController extends Controller
{
    private const ERROR_MESSAGES = [
        'numeric' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов'
    ];

    private const STORE_VALIDATOR = [
        'pole' => 'numeric',
        'kultura' => 'numeric',
        'date' => 'date',
        'szrClasses' => 'numeric',
        'szr' => 'numeric',
        'doza' => 'numeric',
        'volume' => 'numeric',
        'comment' => 'nullable|max:500',
    ];
    public function __construct()
    {
        //$this->middleware('can:delete, App\Models\Spraying')->only('destroy');
        $this->middleware('can:viewAny, App\Models\Spraying');

       // $this->authorizeResource(Spraying::class, 'spraying');

    }
    private function  display_null($value){

        return $value ?: 'Н/Д';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $arr = [];


        foreach (Spraying::with('pole.filial')->get() as $value){
            $arr [$value['pole'] ['filial'] ['name']][$value['pole']['id']] = $value;
        }

        return view('spraying.index', ['arr' => $arr]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $sevooborot_arr = [];
        $squaret_arr = [];
        $szr_arr = [];

        foreach (Sevooborot::all() as $value){
            $sevooborot_arr [$value->pole_id] [$value->id] =  $value->Nomenklature->name  . ' ' . $this->display_null($value->Reproduktion->name ?? null) . ' ('. $value->square .' Га)';
            $squaret_arr [$value->pole_id] [$value->id] =  $value->square;
        }

        foreach (Szr::all() as $value){
            $szr_arr [$value->szr_classes_id] [$value->id] = $value->name;
        }

        return view('spraying.сreateDeviceAction', [
            'sevooborot_arr' => json_encode($sevooborot_arr, JSON_UNESCAPED_UNICODE),
            'squaret_arr' => json_encode($squaret_arr, JSON_UNESCAPED_UNICODE),
            'szr_arr' => json_encode($szr_arr, JSON_UNESCAPED_UNICODE)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate(self::STORE_VALIDATOR, self::ERROR_MESSAGES);
        Spraying::create([
            'pole_id' => $validation['pole'],
            'date' => $validation['date'],
            'sevooborot_id' =>  $validation['kultura'],
            'szr_id' => $validation['szr'],
            'doza' => $validation['doza'],
            'volume' => $validation['volume'],

            'comments'=> $validation['comment'],
            'user_id' => auth()->user()->id



        ]);

        return redirect()->route('spraying.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pole $spraying)
    {


        return view('spraying.show', ['spraying' =>  Spraying::where('pole_id', $spraying->id)->orderby('date', 'desc')->get(), 'pole_name' => $spraying->name]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Spraying $spraying)
    {
        return view('spraying.edit', ['spraying' => $spraying]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Spraying $spraying)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spraying $spraying)
    {

        if (auth()->user()->can('delete', $spraying))
        {

            $spraying->update(['user_id' => auth()->user()->id]);

            $spraying->delete();
        }
        return redirect()->route('spraying.index', $spraying);
    }

}
