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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SprayingController extends Controller
{

    private array $check;

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
        if ($sprayings->isNotEmpty()) {
            foreach ($sprayings->sortBy('pole.name')->sortBy('pole.filial.name') as $value) {
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
            ->join('poles', function (JoinClause $join) {
                $join->on('sevooborots.pole_id', '=', 'poles.id')
                    ->where('filial_id', '=', Auth::user()->Registration->filial_id);
            })
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
                'sevooborot_id' => $request['kultura'],
                'szr_id' => $request['szr'],
                'doza' => $request['dosage'],
                'volume' => $request['volume'],
                'comments' => $request['comment'],
                'user_id' => auth()->user()->id
            ]);

        return redirect()->route('spraying.show', ['spraying' => $request['pole']]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Pole $spraying, HarvestShow $harvestShow)
    {
        $harvest = new HarvestAction();

        $this->check = DB::table('sprayings')
            ->select(DB::raw('
            sprayings.id as id,
            sprayings.date,
            interval_day_start,
            interval_day_end,
            dosage,
            LEAD(date) OVER (ORDER BY date DESC) as lead_date,
            LEAD(interval_day_start) OVER (ORDER BY date DESC) as lead_interval_day_start,
            LEAD(interval_day_end) OVER (ORDER BY date DESC) as lead_interval_day_end
            '))
            ->leftJoin('szrs', 'sprayings.szr_id', '=', 'szrs.id')
            ->leftJoin('sevooborots', 'sprayings.sevooborot_id', '=', 'sevooborots.id')
            ->where('interval_day_start', '<>', null)
            ->where('harvest_year_id', '=', $harvest->HarvestYear(now()))
            ->where('sprayings.pole_id', $spraying->id)
            ->where('deleted_at', null)
            ->get()
            ->groupBy('id')
            ->toArray();

        $this->badIntervalSpraying();
        $this->nextIntervalDay();
        $this->badDateSpraying();

        $sprayings = Spraying::query()
            ->where('pole_id', $spraying->id)
            ->with('Sevooborot.HarvestYear')
            ->orderby('date', 'desc')
            ->get();

        if ($sprayings->isNotEmpty()) {
            $harvest_show = $harvestShow->HarvestShow($sprayings->groupBy('Sevooborot.HarvestYear.id'));
            $sprayings = $sprayings->groupBy('Sevooborot.HarvestYear.name');
        }

        return view('spraying.show', [
            'sprayings' => $sprayings,
            'harvest_show' => $harvest_show,
            'check' => $this->check,
        ]);
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

        if (auth()->user()->can('delete', $spraying)) {

            $spraying->update(['user_id' => auth()->user()->id]);

            $spraying->delete();
        }
        return response()->json(['status' => true, "redirect_url" => url('spraying', ['spraying' => $spraying->pole_id])]);
    }

    private function badDateSpraying(): void
    {
        if (array_key_exists(array_key_first($this->check), $this->check) && !Carbon::parse($this->check[array_key_first($this->check)][0]->date)->addDays($this->check[array_key_first($this->check)][0]->interval_day_end)->lessThanOrEqualTo(now())) {
            $this->check[array_key_first($this->check)][0]->badDateSpraying = "Дата опрыскивания просрочена";
        }
    }

    private function badIntervalSpraying(): void
    {
        foreach ($this->check as $value) {
            $this->check[$value[0]->id][0]->badDateSpraying = null;
            if ($value[0]->lead_date !== null && !Carbon::parse($value[0]->date)
                    ->between(
                        Carbon::parse($value[0]->lead_date)->addDays($value[0]->lead_interval_day_start),
                        Carbon::parse($value[0]->lead_date)->addDays($value[0]->lead_interval_day_end)
                    )) {

                $this->check[$value[0]->id][0]->badIntervalSpraying = 'Нарушение интервала обработки';
            } else {
                $this->check[$value[0]->id][0]->badIntervalSpraying = null;
            }
        }
    }

    private function nextIntervalDay(): void
    {
        foreach ($this->check as $id => $value) {
            $this->check[$id][0]->nextIntervalDay = "Дата следующей обработки c " .
                Carbon::parse($value[0]->date)->addDays($value[0]->interval_day_start)->format('d.m.Y') .
                " по " . Carbon::parse($value[0]->date)->addDays($value[0]->interval_day_end)->format('d.m.Y');

        }

    }


}
