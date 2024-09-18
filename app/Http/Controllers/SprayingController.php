<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Actions\harvest\HarvestShow;
use App\Http\Requests\SprayingRequest;
use App\Models\Pole;
use App\Models\Sevooborot;
use App\Models\Spraying;
use App\Models\Szr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SprayingController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:viewAny, App\Models\Spraying');

    }
    private function  display_null($value)
    {

        return $value ?: 'Н/Д';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $arr = [];
        $sprayings = Spraying::query()->with('pole.filial')->get();
        if ($sprayings->isNotEmpty()){
            foreach ($sprayings->sortBy('pole.name')->sortBy('pole.filial.name') as $value){
                $arr [$value['pole'] ['filial'] ['name']][$value['pole']['id']] = $value;
            }
        }

        return view('spraying.index', ['arr' => $arr]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(HarvestAction $harvestAction)
    {

        $sevooborot_arr = [];
        $squaret_arr = [];
        $szr_arr = [];

        $poles = Sevooborot::query()
            ->with('Pole')
            ->where('harvest_year_id', $harvestAction->HarvestYear(now()))
            ->get();

        if($poles->isNotEmpty()){
            $poles = $poles
                ->where('Pole.filial_id', Auth::user()->Registration->filial_id)
                ->groupBy('Pole.name');
        }


        foreach (Sevooborot::query()->where('harvest_year_id', $harvestAction->HarvestYear(now()))->get() as $value){
            $sevooborot_arr [$value->pole_id] [$value->id] =
                $value->Nomenklature->name  . ' ' .
                $this->display_null($value->Reproduktion->name ?? null) . ' ('. $value->square .' Га)';
            $squaret_arr [$value->pole_id] [$value->id] =  $value->square;
        }

        foreach (Szr::all() as $value){
            $szr_arr [$value->szr_classes_id] [$value->id] = $value->name;
        }

        return view('spraying.create', [
            'sevooborot_arr' => json_encode($sevooborot_arr, JSON_UNESCAPED_UNICODE),
            'squaret_arr' => json_encode($squaret_arr, JSON_UNESCAPED_UNICODE),
            'szr_arr' => json_encode($szr_arr, JSON_UNESCAPED_UNICODE),
            'poles' => $poles,
        ]);
    }

    /**
     * Store a newly created resource in storagebox.
     */
    public function store(SprayingRequest $request)
    {

        Spraying::query()
            ->create([
                'pole_id' => $request['pole'],
                'date' => $request['date'],
                'sevooborot_id' =>  $request['kultura'],
                'szr_id' => $request['szr'],
                'doza' => $request['dosage'],
                'volume' => $request['volume'],
                'comments'=> $request['comment'],
                'user_id' => auth()->user()->id
                ]);

        return redirect()->route('spraying.show', ['spraying' => $request['pole']]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Pole $spraying, HarvestShow $harvestShow)
    {
        $sprayings = Spraying::query()
            ->where('pole_id', $spraying->id)
            ->with('Sevooborot.HarvestYear')
            ->orderby('date', 'desc')
            ->get();

        if($sprayings->isNotEmpty()){
            $harvest_show = $harvestShow->HarvestShow($sprayings->groupBy('Sevooborot.HarvestYear.id'));
            $sprayings = $sprayings->groupBy('Sevooborot.HarvestYear.name');
        }

        return view('spraying.show', ['sprayings' =>  $sprayings, 'harvest_show' => $harvest_show]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Spraying $spraying)
    {
        return view('spraying.edit', ['spraying' => $spraying]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(Request $request, Spraying $spraying)
    {
        //
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(Spraying $spraying)

    {

        if (auth()->user()->can('delete', $spraying))
        {

            $spraying->update(['user_id' => auth()->user()->id]);

            $spraying->delete();
        }
        return response()->json(['status'=>true,"redirect_url"=>url('spraying', ['spraying' => $spraying->pole_id])]);
    }

}
