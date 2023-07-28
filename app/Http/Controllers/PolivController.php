<?php

namespace App\Http\Controllers;

use App\Models\Nomenklature;
use App\Models\Pole;
use App\Models\Poliv;
use App\Models\Registration;
use App\Models\Reproduktion;
use App\Models\Sevooborot;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PolivController extends Controller
{
    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов',
        'integer' => 'Может быть только целым числом',
        'image' => 'Файл может быть только изображением'
    ];
    private const POLIV_VALIDATOR = [
        'MM' => 'required|integer',
        'pole' => 'required',
        'gidrant' => 'required',
        'sector' => 'required',
        'date'  => 'required',
        'speed' => 'nullable|integer',
        'KAC' => 'nullable|integer',
        'comment' => 'nullable|max:500'
    ];


    public function polivAddShow(){
        return view('poliv_add');
    }

    public function polivShow(Request $request){

        $pole = Poliv::distinct('pole_id')->get();

        foreach ($pole as $value){
            //Первый вариант (неверный)
            //$arr [$value->filial_id] [$value->pole_id] = Pole::where('id', $value->pole_id)->value('name');
            //Второй вариант, обращение через связь
            $arr [$value->filial_id] [$value->pole_id] = $value->pole->name;
        }

        if (!empty($arr)){
            ksort($arr);
        } else {
            $arr = [];
        }


        if (!empty($request->filial_id) and (!empty($request->pole_id))){
            $f_id = $request->filial_id;
            $p_id = $request->pole_id;
        }
        else {
            $f_id = 0;
            $p_id = 0;
        }

        return view('poliv_show', ['arr' => $arr, 'f_id' => $f_id, 'p_id' => $p_id]);
    }

    public function polivAdd(Request $request){


        $validated = $request->validate(self::POLIV_VALIDATOR,self::ERROR_MESSAGES);

        $user_reg = Registration::where('user_id', Auth::user()->id)->first();
        Poliv::create([
            'filial_id' => $user_reg->filial_id,
            'pole_id' => $validated['pole'],
            'gidrant' => $validated['gidrant'],
            'sector' => $validated['sector'],
            'date' => $validated['date'],
            'poliv' => $validated['MM'],
            'speed' => $validated['speed'],
            'KAC' => $validated['KAC'],
            'comment' => $validated['comment']]);
        return redirect()->route('poliv.add');
    }

    public function polivdestroy (Poliv $poliv){
        $poliv->delete();
        return redirect()->route('poliv.view');
    }

    public function polivEdit (Request $request){
        return view('poliv_edit', ['id' => $request->polivId]);

    }



}


