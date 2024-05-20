<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Models\HarvestYear;
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
        $this->middleware('can:delete,sevooborot')->only('destroy', 'update');
        $this->middleware('auth')->except('index');
    }
    private const ERROR_MESSAGES = [
        'numeric' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов'
    ];

    private const STORE_VALIDATOR = [
        'cultivation' => 'numeric',
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
        $sevooborots = Sevooborot::query()
            ->with(['HarvestYear', 'Nomenklature', 'Reproduktion'])
            ->where('pole_id', $pole->id)
            ->get();

        if ($sevooborots->isNotEmpty()){
            $sevooborots = $sevooborots->sortByDesc('HarvestYear.name')->groupBy(['HarvestYear.name']);
        } else{
            $sevooborots = [];
        }

        return view('sevooborot.index',
            [
                'pole' => $pole,
                'flag' => '',
                'sevooborots' => $sevooborots,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Pole $pole, HarvestAction $harvestAction)
    {

        $nomen_arr = Nomenklature::query()
            ->select('cultivation_id','name', 'id')
            ->orderby('name')
            ->get()
            ->groupBy(['cultivation_id', 'name'])
            ->map(function ($item) {
                foreach ($item as $id){
                    $return [$id[0]->name] =  $id[0]->id;
                }
                return $return;
            });

        $reproduction = Reproduktion::query()
            ->get()
            ->groupBy('cultivation_id')
            ->map(function ($item){
                foreach ($item as $id){
                    $return [$id->id] = $id->name;
                }
                return $return;
            })
        ;

        $harvest_year = HarvestYear::query()
            ->get()
            ->sortBy('name')
        ;

        $harvest_year_selected_id = $harvestAction->HarvestYear(now());

        return view('sevooborot.create',
            [
                'pole' => $pole,
                'nomen_arr' => json_encode($nomen_arr, JSON_UNESCAPED_UNICODE),
                'reprod_arr' => json_encode($reproduction, JSON_UNESCAPED_UNICODE),
                'harvest_year' => $harvest_year,
                'harvest_year_selected_id' => $harvest_year_selected_id,
            ]);

    }

    /**
     * Store a newly created resource in storagebox.
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
            'cultivation_id' => $request->cultivation,
            'nomenklature_id' => $request->nomenklature,
            'reproduktion_id' => $reproduktion,
            'pole_id' => $pole->id,
            'square' => $request->square,
            'harvest_year_id' => $request->year

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
     * Update the specified resource in storagebox.
     */
    public function update(Request $request, Pole $pole, Sevooborot $sevooborot)
    {
       //
    }

    /**
     * Remove the specified resource from storagebox.
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
