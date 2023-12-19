<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Models\SowingOutfit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SowingOutfitController extends Controller
{
    public function index(HarvestAction $harvestAction)
    {
        return view('sowing.outfit.index', ['harvest_year_id' => $harvestAction->HarvestYear(Carbon::now())]);
    }

    public function create()
    {
        return view('sowing.outfit.create');
    }

    public function store(Request $request, HarvestAction $harvestAction)
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
}
