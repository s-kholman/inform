<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Actions\harvest\HarvestShow;
use App\Http\Requests\WateringStoreRequest;
use App\Models\Pole;
use App\Models\Watering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WateringController extends Controller
{
    public function index(){
        $pole = Watering::query()
            ->with(['Filial', 'Pole'])
            ->distinct('pole_id')
            ->get()
        ;

        if ($pole->isNotEmpty()){
            $pole = $pole->sortBy('Pole.name')->sortBy('Filial.name')->groupBy(['Filial.name', 'Pole.name']);
        } else{
            $pole = [];
        }

        return view('watering.index', ['pole' => $pole]);
    }

    public function show(Request $request, HarvestShow $harvestShow){

        $watering = Watering::query()
            ->with('HarvestYear')
            ->where('filial_id', $request->filial_id)
            ->where('pole_id', $request->pole_id)
            ->get();
        if($watering->isNotEmpty()){
            $watering = $watering
                ->sortByDesc('date')
                ->sortByDesc('HarvestYear.name')
                ->groupBy('HarvestYear.name');
            $harvest_show = $harvestShow->HarvestShow(Watering::query()
                ->with('HarvestYear')
                ->get()
                ->groupBy('HarvestYear.id'));
            $pole = Pole::query()
                ->with('Filial')
                ->find($request->pole_id);
        } else{
            $watering = [];
            $harvest_show = [];
            $pole = Pole::query()
                ->with('Filial')
                ->find($request->pole_id);
        }

            return view('watering.show', ['waterings' => $watering, 'pole' => $pole, 'harvest_show' => $harvest_show]);
    }

    public function create()
    {

        $poles = Pole::query()
            ->where('filial_id', Auth::user()->FilialName->id)
            ->where('poliv', true)
            ->orderBy('name')
            ->get()
        ;

        return view('watering.create', ['poles' => $poles]);
    }

    public function store(WateringStoreRequest $watering, HarvestAction $harvestAction)
    {
        Watering::query()
            ->create([
                'filial_id' => Auth::user()->FilialName->id,
                'pole_id' => $watering['pole'],
                'gidrant' => $watering['gidrant'],
                'sector' => $watering['sector'],
                'date' => $watering['date'],
                'poliv' => $watering['MM'],
                'speed' => $watering['speed'],
                'KAC' => $watering['KAC'],
                'comment' => $watering['comment'],
                'harvest_year_id' => $harvestAction->HarvestYear($watering['date']),
            ]);
        return redirect()->route('watering.show', ['filial_id' => Auth::user()->FilialName->id, 'pole_id' => $watering['pole']]);
    }

    public function destroy(Watering $watering)
    {
        $watering->delete();
        return redirect()->route('watering.show', ['filial_id' => $watering->filial_id, 'pole_id' => $watering->pole_id]);
    }

    public function edit(Watering $watering)
    {
        return view('watering.edit', ['watering' => $watering]);
    }

}
