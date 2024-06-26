<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Http\Requests\SowingIndexRequest;
use App\Http\Requests\SowingRequest;
use App\Models\Cultivation;
use App\Models\filial;
use App\Models\HarvestYear;
use App\Models\Sowing;
use App\Models\SowingOutfit;
use App\Models\SowingType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SowingController extends Controller
{
    private const ADD_VALIDATOR = [
        0 => 'required|integer',            //ID ФИО            - sowing_last_name_id
        1 => 'required|date',               //Дата              - date
        2 => 'required|integer',            //ID вид посева     - sowing_type_id
        3 => 'required|integer',            //ID день/ночь      - shift_id
        4 => 'required|numeric|min:0',      //Объем             - volume
    ];

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(HarvestAction $harvestAction)
    {
        $this->authorize('create', Sowing::class);

        //Подготавливаем дынные для динамических форм культура
        foreach (Cultivation::all() as $toFormat) {
            $cultivation [$toFormat->sowing_type_id] [$toFormat->id] = $toFormat->name;
        }
        $outfit = [];
        //Подготавливаем данные для динамических форм - список ФИО
        foreach (SowingOutfit::where('harvest_year_id', $harvestAction->HarvestYear(Carbon::now()))->get() as $value) {
            $outfit [$value->filial_id] [$value->sowing_type_id] [$value->sowing_last_name_id] = $value->SowingLastName->name;
        }

        if (Auth::user()->email === 'sergey@krimm.ru'){
            $filials = filial::query()
                ->orderBy('name')
                ->get();
        } else{
            $filials = filial::query()
                ->where('id', Auth::user()->Registration->filial_id)
                ->get();
        }

        $content =
            [
                'cultivation' => json_encode($cultivation, JSON_UNESCAPED_UNICODE),
                'outfit' => json_encode($outfit, JSON_UNESCAPED_UNICODE),
                'filials' => $filials
            ];

        return view('sowing.create', $content);

    }

    /**
     * @param SowingRequest $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(SowingRequest $request, HarvestAction $harvestAction)//: RedirectResponse
    {
        $filial = $request->filial;
        $sowing_type = $request->sowing_type;
        unset($request['filial']);
        unset($request['sowing_type']);
        unset($request['_token']);

        $arr_chunk = array_chunk($request->post(), 5);

        foreach ($arr_chunk as $value) {
            $validation = Validator::make($value, self::ADD_VALIDATOR);

            if ($validation->passes() and ($value[4] == 0)) {

                $validated = $validation->validated();
                //dd($validated);
                Sowing::query()
                    ->where('date', $validated[1])
                    //->where('sowing_type_id', $validated[2])
                    ->where('sowing_type_id', $sowing_type)
                    ->where('sowing_last_name_id', $validated[0])
                    ->delete();
            } elseif ($validation->passes()) {
                $validated = $validation->validated();
                $outfit = SowingOutfit::query()
                    ->where('sowing_last_name_id', $validated[0])
                    ->where('sowing_type_id', $sowing_type)
                    ->where('filial_id', $filial)
                    ->where('harvest_year_id', $harvestAction->HarvestYear($validated[1]))
                    ->first();

                Sowing::query()
                    ->updateOrCreate(
                        [
                            'date' => $validated[1],
                            'sowing_last_name_id' => $validated[0],
                            'filial_id' => $filial,
                            'sowing_type_id' => $sowing_type,
                            'machine_id' => $outfit->machine_id,
                            'cultivation_id' => $validated[2],
                            'sowing_outfit_id' => $outfit->id,
                            'harvest_year_id' => $harvestAction->HarvestYear($validated[1])
                        ],
                        [
                            'shift_id' => $validated[3],
                            'volume' => $validated[4],

                        ]);
            }
        }
        return redirect()->route('sowing.index', ['id' => $sowing_type]);
    }

    public function index(SowingIndexRequest $request, HarvestAction $harvestAction)
    {

        $no_machine = SowingType::query()->where('id', $request->id)->value('no_machine');

        $harvest_all = HarvestYear::query()
            ->whereHas('outfitHarvest', function (Builder $query) use ($request) {
               $query->where('sowing_outfits.sowing_type_id', $request->id);
            })
            ->orderByDesc('name')
            ->get();


       // if ($request->harvest == null && $harvest_all->isEmpty()) {
        if ($request->harvest == null) {
            $harvest = $harvestAction->HarvestYear(Carbon::now());
        } elseif ($request->harvest <> null) {
            $harvest = $request->harvest;
        } else {
            $harvest = $harvest_all->first()->id;
        }

        $sowing = Sowing::query()
            ->select('sowings.*', 'filials.name as filial_name', 'cultivations.color as color', 'cultivations.name as cultivations_name')
            ->where('sowings.sowing_type_id', $request->id)
            ->where('harvest_year_id', $harvest)
            ->where('machine_id', $no_machine ? '=' : '<>', null)
            ->join('filials', 'filials.id', '=', 'sowings.filial_id')
            ->leftJoin('machines', 'machines.id', '=', 'sowings.machine_id')
            ->join('cultivations', 'cultivations.id', '=', 'sowings.cultivation_id')
            ->orderBy('filials.name')
            ->orderBy($no_machine ? 'machines.id' : 'cultivations.name')
            ->get();


        if ($no_machine) {
            $group = ['filial_id', 'cultivation_id', 'sowing_last_name_id'];
        } else {
            $group = ['filial_id', 'machine_id', 'sowing_last_name_id'];
        }

//Группировка по датам, взяли первую дату
        foreach ($sowing->groupBy('date') as $date => $value) {
            $summa = 0;
           // dump($sowing_outfit->groupBy('Sowings.date'));
           // dd($sowing->groupBy('date'));
            //Применяем матрицу таблицы на каждый день вне зависимости от наличия данных
            //Филиал
            foreach ($sowing->groupBy($group) as $filial_id => $machine) {
                //Агрегат
                foreach ($machine as $machine_id => $sowing_last_name) {
                    //ФИО + модель
                    //$temp [$filial_id] [$machine_id] =
                    foreach ($sowing_last_name as $sowing_last_name_id => $nulls) {
                        foreach ($value as $key) {
                            if ($key->date == $date and $key->filial_id == $filial_id and $key->machine_id ? $key->machine_id : $key->cultivation_id == $machine_id and $key->sowing_last_name_id == $sowing_last_name_id) {
                                $result [$date] [$filial_id] [$machine_id] [$sowing_last_name_id] [$key->cultivation_id] = $key;
                                $summa += $key->volume;
                                if (count($result [$date] [$filial_id] [$machine_id] [$sowing_last_name_id]) > 1) {
                                    unset($result [$date] [$filial_id] [$machine_id] [$sowing_last_name_id] ['default']);
                                }
                            } else {
                                $result [$date] [$filial_id] [$machine_id] [$sowing_last_name_id] ['default'] = null;
                                if (count($result [$date] [$filial_id] [$machine_id] [$sowing_last_name_id], COUNT_RECURSIVE) > 1) {
                                    unset($result [$date] [$filial_id] [$machine_id] [$sowing_last_name_id] ['default']);
                                }
                            }
                        }
                    }
                }
            }
            $summa_arr [$date] ['summa'] = $summa;
        }

        $summa_arr [] ['summa'] = 0;
        $sowing_type = SowingType::query()->find($request->id);
      //  dd($sowing_type);
        if (!empty($result)) {
            ksort($result);

            $cultivationToSum = ($sowing->groupBy(['filial_id', 'cultivation_id'])->map(function ($query){
                foreach ($query as $value){
                     $arr [$value[0]->filial_name] [$value[0]->cultivations_name] = ['volume' => $value->sum('volume'), 'color' => $value[0]->color];
                }
                return $arr;
            }));

///dd($cultivationToSum);
            $cultivationToKRIMM = $sowing->groupBy(['cultivations_name'])->map(function ($builder){
                    return ['volume' => $builder->sum('volume'), 'color' => $builder[0]->color];
            });
            //dd($cultivationToKRIMM);

            return view('sowing.index',
                [
                    'result' => $result,
                    'summa_arr' => $summa_arr,
                    'harvest_year_id' => $harvest,
                    'harvest_all' => $harvest_all,
                    'sowing_type_model' => $sowing_type,
                    'no_machine' => $no_machine,
                    'cultivationToSum' => $cultivationToSum,
                    'cultivationToKRIMM' => $cultivationToKRIMM,

                ]);
        } else
            return view('sowing.index',
            [
                'result' => $result = 0,
                'summa_arr' => $summa_arr = 0,
                'harvest_year_id' => $harvest,
                'harvest_all' => $harvest_all,
                'sowing_type_model' => $sowing_type,
                'cultivationToSum' => [],
                'cultivationToKRIMM' => [],

            ]);
    }

}
