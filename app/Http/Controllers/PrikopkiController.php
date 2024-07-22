<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Http\Requests\PrikopkiRequest;
use App\Models\Pole;
use App\Models\Prikopki;
use App\Models\PrikopkiSquare;
use App\Models\Sevooborot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrikopkiController extends Controller
{

    private function  display_null($value){

        return $value ?: 'Н/Д';
    }

    public function index()
    {
        $prikopkis = Prikopki::query()
            ->with(['filial', 'sevooborot', 'sevooborot.Pole'])
            ->get()
            ->sortBy('sevooborot.pole.name')
            ->groupBy('filial.name')

        ;

        return view('prikopki.index', ['prikopkis' => $prikopkis]);
    }

    public function create(HarvestAction $harvestAction)
    {
        $sevooborot_arr = [];
        $filial_id = Auth::user()->Registration->filial_id;

        $poles = Sevooborot::query()
            ->with('Pole')
            ->where('harvest_year_id', $harvestAction->HarvestYear(now()))
            ->get();

        if($poles->isNotEmpty()){
            $poles = $poles
                ->where('Pole.filial_id', $filial_id)
                ->groupBy('Pole.name');
        }


        foreach (Sevooborot::query()->where('harvest_year_id', $harvestAction->HarvestYear(now()))->get() as $value){
            $sevooborot_arr [$value->pole_id] [$value->id] =
                $value->Nomenklature->name  . ' ' .
                $this->display_null($value->Reproduktion->name ?? null) . ' ('. $value->square .' Га)';
        }

        $prikopki_squares = PrikopkiSquare::query()->get();

        return view('prikopki.create',[
            'sevooborot_arr' => json_encode($sevooborot_arr, JSON_UNESCAPED_UNICODE),
            'poles' => $poles,
            'prikopki_squares' => $prikopki_squares,
            'filial_id' => $filial_id,]);
    }

    public function store(PrikopkiRequest $request)
    {

        Prikopki::query()
            ->create([
                'date' => $request['date'],
                'filial_id' => $request['filial_id'],
                'sevooborot_id' => $request['sevooborot'],
                'prikopki_square_id' => $request['prikopki_squares'],
                'fraction_1' => $request['fraction_1'],
                'fraction_2' => $request['fraction_2'],
                'fraction_3' => $request['fraction_3'],
                'fraction_4' => $request['fraction_4'],
                'fraction_5' => $request['fraction_5'],
                'fraction_6' => $request['fraction_6'],
                'comment' => $request['comment'],
            ]);

        //dd($request->post());
        return redirect()->route('prikopki.index');
    }

    public function show(Request $request)
    {
        $prikopkis = Prikopki::query()
            ->with(['sevooborot', 'PrikopkiSquare'])
            ->orderBy('date')
            ->get()
            ->where('sevooborot.pole_id', $request->prikopki)
        ;

        if ($prikopkis->count() > 0 ){
            $pole_name = Pole::query()->find($request->prikopki)->name;
        } else {
            $pole_name = null;
        }
        return view('prikopki.show', ['prikopkis' => $prikopkis, 'pole_name' => $pole_name]);
    }

    public function destroy(Prikopki $prikopki)
    {
        $this->authorize('delete', $prikopki);
        $prikopki->delete();
        return response()->json(['status'=>true,"redirect_url"=>url('prikopki')]);
    }
}
