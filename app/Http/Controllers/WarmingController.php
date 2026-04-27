<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Http\Requests\WarmingRequest;
use App\Models\StorageName;
use App\Models\Warming;
use App\Models\WarmingControl;
use Illuminate\Support\Facades\Auth;

class WarmingController extends Controller
{
    public function index(HarvestAction $harvestAction)
    {
        $this->authorize('view', Warming::class);

        $warming = Warming::query()
            ->with(['warmingControl', 'warmingControl.user.Registration', 'storageName.filial'])
            ->where('harvest_year_id', $harvestAction->HarvestYear(now()))
            ->get()
            ->sortBy(['storageName.filial.name','warming_date'])
            ->groupBy('storageName.filial_id')
        ;
        return view('warming.index', ['warming' => $warming]);
    }

    public function create()
    {
        $this->authorize('create', Warming::class);

        $storage_name = StorageName::query()->get()->sortBy('name');

        return view('warming.create', ['storage_name' => $storage_name]);
    }

    public function edit(Warming $warming)
    {
        $this->authorize('edit', Warming::class);

        return view('warming.edit', ['warming' => $warming]);
    }

    public function update(WarmingRequest $warmingRequest, Warming $warming){

        $this->authorize('update', Warming::class);

        $warming->update(
            [
                'volume' => $warmingRequest['volume'],
                'warming_date' => $warmingRequest['warming_date'],
                'sowing_date' => $warmingRequest['sowing_date'],
                'comment' => $warmingRequest['comment'],
            ]
        );

        $this->warmingControl($warming, $warmingRequest);

        return redirect()->route('warming.index');
    }

    public function store(WarmingRequest $warmingRequest, HarvestAction $harvestAction)
    {
        $this->authorize('update', Warming::class);

        $warmingModel = Warming::query()
            ->create([
                'storage_name_id' => $warmingRequest['storage_name_id'],
                'volume' => $warmingRequest['volume'],
                'warming_date' => $warmingRequest['warming_date'],
                'sowing_date' => $warmingRequest['sowing_date'],
                'comment' => $warmingRequest['comment'],
                'harvest_year_id' => $harvestAction->HarvestYear(now()),
            ]);

        $this->warmingControl($warmingModel, $warmingRequest);

        return redirect()->route('warming.index');
    }

    public function destroy(Warming $warming)
    {
        $this->authorize('delete', $warming);

        $svyaz = WarmingControl::query()
            ->where('warming_id', $warming->id)
            ->count();

        if ($svyaz == 0) {
            $warming->delete();
            return response()->json(['status'=>true,"redirect_url"=>route('warming.index')]);
        }

        return response()->json(['status'=>false, 'type' => 'Удаление не возможно','message' => 'В записи присутствует контроль', "redirect_url"=>route('warming.index')]);
        //return false;

    }

    private function warmingControl(Warming $warming, WarmingRequest $warmingRequest)
    {
        $level = 0;
        $text = '';

        if ($warmingRequest['comment_deputy_director'] && Auth::user()->hasRole('Warming.deploy')) {
            $text =  $warmingRequest['comment_deputy_director'];
            $level = 2;
        } elseif ($warmingRequest['comment_agronomist'] && Auth::user()->hasRole('Warming.completed')){
            $text =  $warmingRequest['comment_agronomist'];
            $level = 1;
        }

        if ($level <> 0){
            WarmingControl::query()
                ->create([
                    'warming_id' => $warming->id,
                    'user_id' => Auth::user()->id,
                    'text' => $text,
                    'level' => $level
                ]);
        }
    }
}
