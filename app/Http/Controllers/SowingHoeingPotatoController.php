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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SowingHoeingPotatoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $sowing_hoeing_potatoes = SowingHoeingPotato::query()
            ->with(['Filial', 'Pole', 'SowingLastName'])
            ->get()
        ;

        $string_filial = '';
        $string_pole = '';
        $detail = [];
        if ($sowing_hoeing_potatoes->isNotEmpty()){
            foreach ($sowing_hoeing_potatoes->groupBy('Filial.name') as $filial_name => $sowing_hoeing_potato){
                foreach ($sowing_hoeing_potato->groupBy('Pole.name') as $pole_name => $sowingLastNames){
                    foreach ($sowing_hoeing_potatoes->groupBy('date') as $date => $item)
                    {
                            $detail [$date] [$sowingLastNames[0]->pole_id] = $sowing_hoeing_potatoes
                                ->where('date', $date)
                                ->where('filial_id' , $sowing_hoeing_potato[0]->filial_id)
                                ->where('pole_id' , $sowingLastNames[0]->pole_id)
                                ->sum('volume')
                            ;
                    }
                    $string_pole .=  '<th>' . $pole_name . '</th>';
                }
                $colspan = $sowing_hoeing_potato->groupBy('Pole.name')->count();
                $string_filial .= "<th colspan=$colspan>" . $filial_name . '</th>';
            }
        }

        return view('sowingHoeingPotato.index', [
            'sowing_hoeing_potatoes' => $sowing_hoeing_potatoes,
            'string_filial' => $string_filial,
            'string_pole' => $string_pole,
            'detail' => collect($detail)->sort(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(HarvestAction $harvestAction)
    {
        $post = json_decode(env('POST_ADD_POTATO', '{"DIRECTOR":0,"DEPUTY":0,"AGRONOMIST:0"}'),true);
        $post_user = Auth::user()->registration->post_id;

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
            'post' => $post,
            'post_user' => $post_user,
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
                'hoeing_result_agronomist' => $request->result_control_agronomist,
                'hoeing_result_director' => $request->result_control_director,
                'hoeing_result_deputy_director' => $request->result_control_deputy_director,
                'comment' => $comment,
            ]);
        return redirect()->route('sowing_hoeing_potato.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SowingHoeingPotato $sowingHoeingPotato, Request $request)
    {
        dd($request->pole_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SowingHoeingPotato $sowingHoeingPotato, HarvestAction $harvestAction)
    {

        $post = json_decode(env('POST_ADD_POTATO', '{"DIRECTOR":0,"DEPUTY":0,"AGRONOMIST:0"}'),true);
        $post_user = Auth::user()->registration->post_id;

        if ($post['DEPUTY'] === $post_user){
            $filial_id = $sowingHoeingPotato->filial_id;
        } else{
            $filial_id = Auth::user()->FilialName->id;
        }

        $poles = Pole::query()
            ->where('filial_id', $filial_id)
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
            'post' => $post,
            'post_user' => $post_user,
            'shifts' => $shifts,
            'hoeing_results' => $hoeing_results,
            'sowingHoeingPotato' => $sowingHoeingPotato,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SowingHoeingPotato $sowingHoeingPotato, AcronymFullNameUser $acronymFullNameUser)
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
                'hoeing_result_agronomist' => $request->result_control_agronomist,
                'hoeing_result_director' => $request->result_control_director,
                'hoeing_result_deputy_director' => $request->result_control_deputy_director,
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
        $sowing_hoeing_potatoes = SowingHoeingPotato::query()
            ->with(['TypeFieldWork', 'SowingLastName', 'Pole', 'Filial','HarvestYear', 'Shift'])
            ->where('pole_id', $id)
            ->get()
            ->sortByDesc(['HarvestYear.name', 'date', 'point_control'])
        ;
        return view('sowingHoeingPotato.show', [
            'sowing_hoeing_potatoes' => $sowing_hoeing_potatoes
        ]);
    }
}
