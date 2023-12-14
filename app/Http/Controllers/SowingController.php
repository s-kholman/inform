<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Http\Requests\SowingRequest;
use App\Models\Cultivation;
use App\Models\HarvestYear;
use App\Models\posev;
use App\Models\Sowing;
use App\Models\SowingLastName;
use App\Models\SowingOutfit;
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
    public function create()
    {
        $this->authorize('create', Sowing::class);

        //Подготавливаем дынные для динамических форм культура
        foreach (Cultivation::all() as $toFormat) {
            $cultivation [$toFormat->sowing_type_id] [$toFormat->id] = $toFormat->name;
        }

        //Подготавливаем данные для динамических форм - список ФИО
        foreach (SowingOutfit::where('active', true)->get() as $value) {
            $outfit [$value->filial_id] [$value->sowing_type_id] [$value->sowing_last_name_id] = $value->SowingLastName->name;
        }

        $content = [
            'cultivation' => json_encode($cultivation, JSON_UNESCAPED_UNICODE),
            'outfit' => json_encode($outfit, JSON_UNESCAPED_UNICODE),
            'filial_id' => Auth::user()->Registration];

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
//dd($request);
        $arr_chunk = array_chunk($request->post(), 5);

        foreach ($arr_chunk as $value) {
            $validation = Validator::make($value, self::ADD_VALIDATOR);

            if ($validation->passes() and ($value[4] == 0)) {
                $validated = $validation->validated();
                Sowing::query()
                    ->where('date', $validated[1])
                    ->where('sowing_type_id', $validated[2])
                    ->where('sowing_last_name_id', $validated[0])
                    ->delete();
            }
            elseif ($validation->passes()) {
                $validated = $validation->validated();
                $outfit = SowingOutfit::query()
                    ->where('sowing_last_name_id', $validated[0])
                    ->where('active', true)
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
                            'harvest_year_id' => $harvestAction->HarvestYear($validated[1])
                        ],
                        [
                            'shift_id' => $validated[3],
                            'volume' => $validated[4],

                        ]);
            }
        }
        return redirect()->route('sowing.index', ['type' => $sowing_type]);
    }

    public function index(Request $request, HarvestAction $harvestAction)
    {

        $harvest_all = Sowing::query()
            ->select('harvest_year_id', 'harvest_years.name as harvest_name')
            ->where('sowings.sowing_type_id', $request->type)
            ->join('harvest_years', 'harvest_years.id', '=', 'sowings.harvest_year_id')
            ->orderByDesc('harvest_years.name')
            ->get()
            ->unique('harvest_year_id')
            ->groupBy('harvest_year_id');
        if ($request->harvest == null AND empty($harvest_all)) {
            $harvest = $harvestAction->HarvestYear(Carbon::now());
        } elseif ($request->harvest <> null){
            $harvest = $request->harvest;
        } else{
            $harvest = $harvest_all->first()[0]->harvest_year_id;
        }

        $sowing = Sowing::query()
            ->select('sowings.*','filials.name as filial_name')
            ->where('sowings.sowing_type_id', $request->type)
            ->where('harvest_year_id', $harvest)
            ->join('filials', 'filials.id', '=', 'sowings.filial_id')
            ->join('machines', 'machines.id', '=', 'sowings.machine_id')
            ->orderBy('filials.name')
            ->orderBy('machines.name')
            ->get();

//Группировка по датам, взяли первую дату
        foreach ($sowing->groupBy('date') as $date => $value) {
            $summa = 0;
            //Применяем матрицу таблицы на каждый день вне зависимости от наличия данных
            //Филиал
            foreach ($sowing->groupBy(['filial_id', 'machine_id', 'sowing_last_name_id']) as $filial_id => $machine) {
                //Агрегат
                foreach ($machine as $machine_id => $sowing_last_name) {
                    //ФИО + модель
                    foreach ($sowing_last_name as $sowing_last_name_id => $nulls) {
                        foreach ($value as $key) {
                            if ($key->date == $date and $key->filial_id == $filial_id and $key->machine_id == $machine_id and $key->sowing_last_name_id == $sowing_last_name_id) {
                                $result [$date] [$filial_id] [$machine_id] [$sowing_last_name_id] [$key->cultivation_id] = $key;
                                $summa += $key->volume;
                                if (count($result [$date] [$filial_id] [$machine_id] [$sowing_last_name_id]) > 1){
                                    unset($result [$date] [$filial_id] [$machine_id] [$sowing_last_name_id] ['default']);
                                }
                            } else {
                                $result [$date] [$filial_id] [$machine_id] [$sowing_last_name_id] ['default'] = null;
                                if (count($result [$date] [$filial_id] [$machine_id] [$sowing_last_name_id], COUNT_RECURSIVE) > 1){
                                    unset($result [$date] [$filial_id] [$machine_id] [$sowing_last_name_id] ['default']);
                                }
                            }
                        }
                    }
                }
            }
            $summa_arr [$date] ['summa'] = $summa;
        }

        if (!empty($result)) {
            ksort($result);
            return view('sowing.index',['result' => $result, 'summa_arr' => $summa_arr, 'harvest_year_id' => $harvest, 'harvest_all' => $harvest_all, 'sowing_type_id' => $request->type]);
        } else
            return view('sowing.index',['result' => $result = 0, 'summa_arr' => $summa_arr = 0,'harvest_year_id' => [], 'harvest_all' => $harvest_all, 'sowing_type_id' => $request->type]);
    }

public function posevToSowing(HarvestAction $harvestAction){
        $posev = posev::query()
            ->where('vidposeva_id', 1)
            ->orWhere('vidposeva_id', 2)
            ->get();

        foreach ($posev as $value)
        {
            Sowing::query()->updateOrCreate(
                [
                    'sowing_last_name_id' => self::SowingLastName($value->fio->name)->id,
                    'cultivation_id' => self::toCultivation($value->kultura_id),
                    'filial_id' => $value->filial_id,
                    'shift_id' => $value->sutki_id,
                    'sowing_type_id' => $value->vidposeva_id,
                    'machine_id' => self::toNachine($value->agregat_id),
                    'harvest_year_id' => $harvestAction->HarvestYear($value->posevDate),
                    'date' => $value->posevDate,
                ],
                [
                    'volume' => $value->posevGa
                ]
            );
        }
}

private function SowingLastName($name)
{
    return SowingLastName::query()->where('name', $name)->first();
}

private function toNachine($id)
{
    switch ($id){
        case 1:
            return 1;
        case 2:
            return 2;
        case 3:
            return 3;
        case 4:
            return 4;
        case 5:
            return 5;
        case 6:
            return 6;
        case 7:
            return 7;
        case 14:
            return 8;
        case 8:
            return 9;


    }
}

private function toCultivation($id){

        switch ($id) {
            case 1:
                return 1;
            case 2:
                return 2;
            case 3:
                return 7;
            case 4:
                return 3;
            case 5:
                return 4;
            case 6:
                return 6;
            case 8:
                return 5;
            case 9:
                return 8;
            case 10:
                return 9;


        }
}


}
