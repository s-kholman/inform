<?php

namespace App\Http\Controllers;

use App\Models\Nomenklature;
use App\Models\Pole;
use App\Models\Reproduktion;
use App\Models\Sevooborot;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SevooborotController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:destroy, App\Models\svyaz')->only('destroy', 'update');
        $this->middleware('auth')->except('index');
    }
    private const ERROR_MESSAGES = [
        'numeric' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов'
    ];

    private const STORE_VALIDATOR = [
        'kultura' => 'numeric',
        'nomenklature' => 'numeric',
        'reproduktion' => 'nullable|numeric',
        'square' => 'numeric',
        'year' => 'numeric',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index(Pole $pole)
    {

        return view('sevooborot.index', ['pole' => $pole, 'flag' => '']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Pole $pole)
    {



        //return view('test', ['request' => $pole]);
        foreach (Nomenklature::orderby('name')->get() as $value){
            //$nomen_arr [$value->kultura_id] [$value->id] =  $value->name;
            $nomen_arr [$value->kultura_id] [$value->name] =  $value->id;
        }
        asort($nomen_arr);
        foreach (Reproduktion::all() as $value){
            $reprod_arr [$value->kultura_id] [$value->id] =  $value->name;
        }

        return view('sevooborot.create', ['pole' => $pole,
            'nomen_arr' => json_encode($nomen_arr, JSON_UNESCAPED_UNICODE),
            'reprod_arr' => json_encode($reprod_arr, JSON_UNESCAPED_UNICODE)]);

        //return view('sevooborot.create', ['pole' => $pole]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Pole $pole)
    {
       $d = $request->validate(self::STORE_VALIDATOR, self::ERROR_MESSAGES);
        if ($request->reproduktion == 0){
            $reproduktion = null;
        } else {
            $reproduktion = $request->reproduktion;
        }

        Sevooborot::create([
            'kultura_id' => $request->kultura,
            'nomenklature_id' => $request->nomenklature,
            'reproduktion_id' => $reproduktion,
            'pole_id' => $pole->id,
            'square' => $request->square,
            'year' => $request->year

        ]);

        return redirect()->route('pole.sevooborot.index', ['pole' => $pole->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pole $pole, Sevooborot $sevooborot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pole $pole, Sevooborot $sevooborot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pole $pole, Sevooborot $sevooborot)
    {
       //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pole $pole, Sevooborot $sevooborot)
    {
        try {
            $sevooborot->delete();
        }
        catch (QueryException $e)
        {
            return redirect()->route('pole.sevooborot.index', ['pole' => $pole->id, 'flag' => '1']);
        }
        return redirect()->route('pole.sevooborot.index', ['pole' => $pole->id, 'flag' => '']);
    }
}
