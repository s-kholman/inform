<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Http\Requests\SowingOutfitRequest;
use App\Models\Cultivation;
use App\Models\SowingOutfit;
use App\Models\SowingType;
use Carbon\Carbon;
use Illuminate\Http\Request;


class SowingOutfitController extends Controller
{
    public function index(Request $request)
    {

        $sowing_outfit_harvest = SowingOutfit::query()
            ->select('harvest_year_id')
            ->with('HarvestYear')
            ->get()
            ->unique('harvest_year_id')
            ->sortBy('HarvestYear.name')
        ;
        return view('sowing.outfit.index', ['harvest_year' => $sowing_outfit_harvest, 'year_id' => $request->id]);
    }

    public function create()
    {

        $sowing_type = SowingType::query()
            ->select('id', 'no_machine')
            ->get()
            ->groupBy('id')
            ->toArray();

        $cultivation = Cultivation::query()
            ->select('sowing_type_id', 'name', 'id')
            ->get()
            ->groupBy('sowing_type_id')
            ->toArray();

        return view('sowing.outfit.create',
            [
                'SowingType' => json_encode($sowing_type),
                'Cultivation' => json_encode($cultivation),
            ]
        );
    }

    public function store(SowingOutfitRequest $request, HarvestAction $harvestAction)
    {
        SowingOutfit::query()
            ->firstOrCreate(
                [
                    'sowing_last_name_id' => $request->sowing_last_name,
                    'filial_id' => $request->filial,
                    'machine_id' => $request->machine,
                    'sowing_type_id' => $request->sowing_type,
                    'cultivation_id' => $request->cultivation,
                    'harvest_year_id' => $harvestAction->HarvestYear(Carbon::now()),
                ],
            );
        return redirect()->route('outfit.index');
    }

    public function destroy(SowingOutfit $outfit)
    {
        $outfit->delete();
        return response()->json(['status'=>true,"redirect_url"=>url('sowing/outfit/index')]);
    }
}
