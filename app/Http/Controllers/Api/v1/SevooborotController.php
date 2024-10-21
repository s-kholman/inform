<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\harvest\HarvestAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\SevooborotResource;
use App\Models\Sevooborot;

class SevooborotController extends Controller
{
    public function __invoke($id, HarvestAction $harvestAction)
    {
        return SevooborotResource::collection(Sevooborot::query()
            ->with(['Nomenklature', 'Reproduktion'])
            ->where('pole_id', $id)
            ->where('harvest_year_id', $harvestAction->HarvestYear(now()))
            ->get())
            ;

    }
}
