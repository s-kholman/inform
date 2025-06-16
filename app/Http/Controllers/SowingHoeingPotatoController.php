<?php

namespace App\Http\Controllers;

use App\Actions\Acronym\AcronymFullNameUser;
use App\Actions\harvest\HarvestAction;
use App\Http\Requests\SowingHoeingPotatoRequest;
use App\Models\HoeingResult;
use App\Models\Pole;
use App\Models\Shift;
use App\Models\SowingHoeingPotato;
use App\Models\SowingLastName;
use App\Models\TypeFieldWork;
use Illuminate\Support\Facades\Auth;

class SowingHoeingPotatoController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SowingHoeingPotato::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $local = false;
            if (env('APP_ENV') == 'local'){
                $local = true;
            }

        $sowing_hoeing_potatoes = SowingHoeingPotato::query()
            ->with(['Filial', 'Pole', 'HarvestYear'])
            ->when($local, function ($query){return $query->limit(50);})
            ->get()
            ->sortBy(['Filial.name', 'Pole.name']);

        $r_string_filial = '';
        $detail = [];

        if ($sowing_hoeing_potatoes->isNotEmpty()) {

            foreach ($sowing_hoeing_potatoes as $value) {
                if (isset($detail [$value->HarvestYear->name] [$value->date] [$value->pole_id])) {
                    $detail [$value->HarvestYear->name] [$value->date] [$value->pole_id] += $value->volume;
                } else {
                    $detail [$value->HarvestYear->name] [$value->date] [$value->pole_id] = $value->volume;
                }
            }

            foreach ($sowing_hoeing_potatoes->groupBy('HarvestYear.name') as $yearName => $value) {
                foreach ($value->groupBy('Filial.name') as $filial_name => $sowing_hoeing_potato) {
                    $colspan = $sowing_hoeing_potato->groupBy('Pole.name')->count();
                    $r_string_filial .= "<th colspan=$colspan>" . $filial_name . '</th>';
                }
                $string_filial [$yearName] = $r_string_filial;
                $r_string_filial = '';
            }

            return view('sowingHoeingPotato.index', [
                'sowing_hoeing_potatoes' => $sowing_hoeing_potatoes,
                'string_filial' => $string_filial,
                'detail' => collect($detail)->sortKeysDesc(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $poles = Pole::query()
            ->where('filial_id', Auth::user()->FilialName->id)
            ->orderBy('name')
            ->get()
        ;

        $shifts = Shift::query()
            ->get();

        $sowing_last_names = SowingLastName::query()
            ->with('filial')
            ->where('filial_id', Auth::user()->FilialName->id)
            ->orWhere('filial_id', null)
            ->get()
            ->sortBy('name')
        ;

        $type_field_works = TypeFieldWork::query()
            ->where('id', 2)
            ->get();

        $hoeing_results = HoeingResult::query()
            ->get();

        return view('sowingHoeingPotato.create', [
            'poles' => $poles,
            'sowing_last_names' => $sowing_last_names,
            'type_field_works' => $type_field_works,
            'shifts' => $shifts,
            'hoeing_results' => $hoeing_results,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SowingHoeingPotatoRequest $request, AcronymFullNameUser $acronymFullNameUser, HarvestAction $harvestAction)
    {
        if($request->comment <> null){
            $comment = $acronymFullNameUser->Acronym(Auth::user()->registration) . ': ' . $request->comment . "\r\n";
        } else{
            $comment = '';
        }

        $filial = Pole::query()->find($request->pole);

        SowingHoeingPotato::query()
            ->create([
                'date' => $request->date,
                'type_field_work_id' => $request->type_field_work,
                'sowing_last_name_id' => $request->sowing_last_name,
                'pole_id' => $request->pole,
                'filial_id' => $filial->filial_id,
                'harvest_year_id' => $harvestAction->HarvestYear(now()),
                'volume' => $request->volume,
                'shift_id' => $request->shift,
                'hoeing_result_agronomist_point_1' => $request->hoeing_result_agronomist_point_1,
                'hoeing_result_agronomist_point_2' => $request->hoeing_result_agronomist_point_2,
                'hoeing_result_agronomist_point_3' => $request->hoeing_result_agronomist_point_3,
                'hoeing_result_director_point_1' => $request->hoeing_result_director_point_1,
                'hoeing_result_director_point_2' => $request->hoeing_result_director_point_2,
                'hoeing_result_director_point_3' => $request->hoeing_result_director_point_3,
                'hoeing_result_deputy_director_point_1' => $request->hoeing_result_deputy_director_point_1,
                'hoeing_result_deputy_director_point_2' => $request->hoeing_result_deputy_director_point_2,
                'hoeing_result_deputy_director_point_3' => $request->hoeing_result_deputy_director_point_3,
                'comment' => $comment,
            ]);
        return redirect()->route('sowing_hoeing_potato.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SowingHoeingPotato $sowingHoeingPotato)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SowingHoeingPotato $sowingHoeingPotato)
    {
        $poles = Pole::query()
            ->where('filial_id', $sowingHoeingPotato->filial_id)
            ->orderBy('name')
            ->get()
        ;

        $sowing_last_names = SowingLastName::query()
            ->with('filial')
            ->where('filial_id', Auth::user()->FilialName->id)
            ->orWhere('filial_id', null)
            ->get()
            ->sortBy('name')
        ;

        $type_field_works = TypeFieldWork::query()
            ->where('id', 2)
            ->get();


        $hoeing_results = HoeingResult::query()
            ->get();

        $shifts = Shift::query()
            ->get();

        return view('sowingHoeingPotato.edit', [
            'poles' => $poles,
            'sowing_last_names' => $sowing_last_names,
            'type_field_works' => $type_field_works,
            'shifts' => $shifts,
            'hoeing_results' => $hoeing_results,
            'sowingHoeingPotato' => $sowingHoeingPotato,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SowingHoeingPotato $sowingHoeingPotato, SowingHoeingPotatoRequest $request , AcronymFullNameUser $acronymFullNameUser)
    {
        if($request->comment <> null){
            $comment = $sowingHoeingPotato->comment . $acronymFullNameUser->Acronym(Auth::user()->registration) . ': ' . $request->comment . "<br/>";
        } else{
            $comment = $sowingHoeingPotato->comment;
        }

        $filial = Pole::query()->find($request->pole);

        $sowingHoeingPotato->update(
            [
                'date' => $request->date,
                'type_field_work_id' => $request->type_field_work,
                'sowing_last_name_id' => $request->sowing_last_name,
                'pole_id' => $request->pole,
                'filial_id' => $filial->filial_id,
                'volume' => $request->volume,
                'shift_id' => $request->shift,
                'hoeing_result_agronomist_point_1' => $request->hoeing_result_agronomist_point_1,
                'hoeing_result_agronomist_point_2' => $request->hoeing_result_agronomist_point_2,
                'hoeing_result_agronomist_point_3' => $request->hoeing_result_agronomist_point_3,
                'hoeing_result_director_point_1' => $request->hoeing_result_director_point_1,
                'hoeing_result_director_point_2' => $request->hoeing_result_director_point_2,
                'hoeing_result_director_point_3' => $request->hoeing_result_director_point_3,
                'hoeing_result_deputy_director_point_1' => $request->hoeing_result_deputy_director_point_1,
                'hoeing_result_deputy_director_point_2' => $request->hoeing_result_deputy_director_point_2,
                'hoeing_result_deputy_director_point_3' => $request->hoeing_result_deputy_director_point_3,
                'comment' => $comment,

            ]);
        return redirect()->route('sowing_hoeing_potato.show_to_pole', ['id' => $request->pole]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SowingHoeingPotato $sowingHoeingPotato)
    {
        $sowingHoeingPotato->delete();
        return response()->json(['status'=>true,"redirect_url"=>url('/sowing_hoeing_potato')]);
    }

    public function showToPole($id)
    {
        $hoeingResults = HoeingResult::query()->select(['id', 'name'])->get()->groupBy('id')->toArray();

        $sowing_hoeing_potatoes = SowingHoeingPotato::query()
            ->with(['TypeFieldWork', 'SowingLastName', 'Pole', 'Filial','HarvestYear', 'Shift'])
            ->where('pole_id', $id)
            ->get()
            ->sortByDesc('HarvestYear.name')
        ;
        return view('sowingHoeingPotato.show', [
            'sowing_hoeing_potatoes' => $sowing_hoeing_potatoes,
            'hoeingResults' => $hoeingResults
        ]);
    }
}
