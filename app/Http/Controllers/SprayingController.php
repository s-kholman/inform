<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Actions\harvest\HarvestShow;
use App\Http\Requests\SprayingRequest;
use App\Models\Pole;
use App\Models\Sevooborot;
use App\Models\Spraying;
use App\Models\SzrClasses;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SprayingController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:viewAny, App\Models\Spraying');

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
        $poles = Sevooborot::query()
            ->where('harvest_year_id', $harvestAction->HarvestYear(now()))
            ->join('poles', function (JoinClause $join){
                $join->on('sevooborots.pole_id', '=', 'poles.id')
                    ->where('filial_id', '=', Auth::user()->Registration->filial_id);})
            ->get()
            ->groupBy('name');

        $szrClasses = SzrClasses::query()->orderby('name')->get();

        return view('spraying.create', [
            'poles' => $poles,
            'szrClasses' => $szrClasses,
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
