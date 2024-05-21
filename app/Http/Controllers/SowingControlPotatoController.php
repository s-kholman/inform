<?php

namespace App\Http\Controllers;

use App\Actions\Acronym\AcronymFullNameUser;
use App\Actions\harvest\HarvestAction;
use App\Http\Requests\SowingControlPotatoRequest;
use App\Models\Pole;
use App\Models\SowingControlPotato;
use App\Models\SowingOutfit;
use App\Models\TypeFieldWork;
use Illuminate\Support\Facades\Auth;

class SowingControlPotatoController extends Controller
{

    public function index()
    {

        $sowing_control_potatoes = SowingControlPotato::query()
            ->with(['Filial', 'Pole'])
            ->get()
            ->groupBy('Filial.name')
        ;

        return view('sowingControlPotato.index', [
            'sowing_control_potatoes' => $sowing_control_potatoes
        ]);
    }

    public function create(HarvestAction $harvestAction){

        $post = json_decode(env('POST_ADD_POTATO', '{"DIRECTOR":0,"DEPUTY":0,"AGRONOMIST:0"}'),true);
        $post_user = Auth::user()->registration->post_id;

        $poles = Pole::query()
            ->where('filial_id', Auth::user()->FilialName->id)
            ->orderBy('name')
            ->get()
        ;

        $sowing_last_names = SowingOutfit::query()
            ->with('SowingLastName')
            ->where('filial_id', Auth::user()->FilialName->id)
            ->where('harvest_year_id', $harvestAction->HarvestYear(now()))
            ->where('sowing_type_id', 2)
            ->get()
            ->sortBy('SowingLastName.name')
            ;

        $type_field_works = TypeFieldWork::query()
            ->get();

        return view('sowingControlPotato.create', [
            'poles' => $poles,
            'sowing_last_names' => $sowing_last_names,
            'type_field_works' => $type_field_works,
            'post' => $post,
            'post_user' => $post_user
        ]);
    }

    public function store(SowingControlPotatoRequest $request, AcronymFullNameUser $acronymFullNameUser, HarvestAction $harvestAction)
    {

        if($request->comment <> null){
            $comment = $acronymFullNameUser->Acronym(Auth::user()->registration) . ': ' . $request->comment . "\r\n";
        } else{
            $comment = '';
        }

        $filial = Pole::query()->find($request->pole);

        SowingControlPotato::query()
            ->create([
                'date' => $request->date,
                'type_field_work_id' => $request->type_field_work,
                'sowing_last_name_id' => $request->sowing_last_name,
                'pole_id' => $request->pole,
                'filial_id' => $filial->filial_id,
                'harvest_year_id' => $harvestAction->HarvestYear(now()),
                'point_control' => $request->point_control,
                'result_control_agronomist' => $request->result_control_agronomist,
                'result_control_director' => $request->result_control_director,
                'result_control_deputy_director' => $request->result_control_deputy_director,
                'comment' => $comment,
            ]);
        return redirect()->route('sowing_control_potato.show_pole',['id' => $request->pole]);
    }

    public function delete(SowingControlPotato $sowingControlPotato)
    {
        $sowingControlPotato->delete();
        return response()->json(['status'=>true,"redirect_url"=>url('/sowing_control_potato/index')]);
    }

    public function edit(SowingControlPotato $sowingControlPotato, HarvestAction $harvestAction)
    {
        $post = json_decode(env('POST_ADD_POTATO', '{"DIRECTOR":0,"DEPUTY":0,"AGRONOMIST:0"}'),true);
        $post_user = Auth::user()->registration->post_id;

        if ($post['DEPUTY'] === $post_user){
            $filial_id = $sowingControlPotato->filial_id;
        } else{
            $filial_id = Auth::user()->FilialName->id;
        }

        $poles = Pole::query()
            ->where('filial_id', $filial_id)
            ->orderBy('name')
            ->get()
        ;

        $sowing_last_names = SowingOutfit::query()
            ->with('SowingLastName')
            ->where('filial_id', $filial_id)
            ->where('harvest_year_id', $harvestAction->HarvestYear(now()))
            ->get()
            ->sortBy('SowingLastName.name')
        ;

        $type_field_works = TypeFieldWork::query()
            ->get();

        return view('sowingControlPotato.edit', [
            'poles' => $poles,
            'sowing_last_names' => $sowing_last_names,
            'type_field_works' => $type_field_works,
            'post' => $post,
            'post_user' => $post_user,
            'sowingControlPotato' => $sowingControlPotato,
        ]);
    }
    public function update(SowingControlPotatoRequest $request, SowingControlPotato $sowingControlPotato, AcronymFullNameUser $acronymFullNameUser)
    {
        if($request->comment <> null){
            $comment = $sowingControlPotato->comment . $acronymFullNameUser->Acronym(Auth::user()->registration) . ': ' . $request->comment . "<br/>";
        } else{
            $comment = $sowingControlPotato->comment;
        }

        $filial = Pole::query()->find($request->pole);

        $sowingControlPotato->update(
            [
                'date' => $request->date,
                'type_field_work_id' => $request->type_field_work,
                'sowing_last_name_id' => $request->sowing_last_name,
                'pole_id' => $request->pole,
                'filial_id' => $filial->filial_id,
                'point_control' => $request->point_control,
                'result_control_agronomist' => $request->result_control_agronomist,
                'result_control_director' => $request->result_control_director,
                'result_control_deputy_director' => $request->result_control_deputy_director,
                'comment' => $comment,
            ]);
        return redirect()->route('sowing_control_potato.show_pole', ['id' => $request->pole]);
    }

    public function showPole($pole_id)
    {
        $sowing_control_potatoes = SowingControlPotato::query()
            ->with(['TypeFieldWork', 'SowingLastName', 'Pole', 'Filial','HarvestYear'])
            ->where('pole_id', $pole_id)
            ->get()
            ->sortByDesc(['HarvestYear.name', 'date', 'point_control'])
        ;
        return view('sowingControlPotato.show', [
            'sowing_control_potatoes' => $sowing_control_potatoes
        ]);
    }

}
