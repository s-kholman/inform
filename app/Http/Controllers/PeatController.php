<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Actions\peat\PeatShowAction;
use App\Http\Requests\PeatRequest;
use App\Models\Peat;
use Illuminate\Support\Facades\Auth;


class PeatController extends Controller
{

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(PeatShowAction $peatShowAction)
    {
        $this->authorize('view', Peat::class);
        return view('peat.index', $peatShowAction->handle());
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id, PeatShowAction $peatShowAction)
    {
        $this->authorize('view', Peat::class);
        return view('peat.index', $peatShowAction->handle($id));
    }

    public function create()
    {
        $this->authorize('create', Peat::class);
        return view('peat.create');
    }

    public function edit(Peat $peat)
    {
        return view('peat.delete', ['peat' => $peat]);
    }

    public function store(PeatRequest $request, HarvestAction $harvestAction)
    {
        Peat::query()->firstOrCreate(
            [
                'date' => $request->date,
                'pole_id' => $request->Pole,
                'peat_extraction_id' => $request->PeatExtraction,
            ],
            [
                'filial_id' => Auth::user()->Registration->filial_id,
                'harvest_year_id' => $harvestAction->HarvestYear($request->date),
                'volume' => $request->volume,
            ]
        );
        return redirect()->route('peat.index');
    }
    public function destroy(Peat $peat)
    {
        $this->authorize('delete', $peat);
        $peat->delete();
        return redirect()->route('peat.show', ['peat' => $peat->harvest_year_id]);
    }
}
