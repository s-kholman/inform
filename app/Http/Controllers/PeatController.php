<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Actions\peat\PeatShowAction;
use App\Http\Requests\PeatRequest;
use App\Models\Peat;
use App\Models\posev;
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

    public function update(HarvestAction $harvestAction)
    {
        $all = posev::query()->where('vidposeva_id', 4)->get();
        foreach ($all as $value) {
            Peat::query()->create(
                [
                    'date' => $value->posevDate,
                    'pole_id' => $this->pole($value->fio_id),
                    'peat_extraction_id' => $this->extraction($value->agregat_id),
                    'filial_id' => $value->filial_id,
                    'harvest_year_id' => $harvestAction->HarvestYear($value->posevDate),
                    'volume' => $value->posevGa,
                ]);
        }
    }

    public function destroy(Peat $peat)
    {
        $this->authorize('delete', $peat);
        $peat->delete();
        return redirect()->route('peat.show', ['peat' => $peat->harvest_year_id]);
    }


    private function extraction($id)
    {
        switch ($id) {
            case 9:
                return 1;
            case 10:
                return 3;
            case 11:
                return 4;
        }
    }

    private function pole($id)
    {
        switch ($id) {
            case 38:
                return 95;
            case 39:
                return 96;
            case 40:
                return 97;
            case 41:
                return 98;
            case 42:
                return 46;
            case 43:
                return 13;
        }
    }

}
