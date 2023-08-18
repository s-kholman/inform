<?php

namespace App\Http\Controllers;

use App\Http\Requests\SamplingProcent;
use App\Models\Box;
use App\Models\Disassembly;
use App\Models\Nomenklature;
use App\Models\Sampling;
use App\Models\StorageName;
use App\Rules\Procents;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     * УДАЛИТЬ
     */

    public function storageAdd(Request $request){
        $storageAdd = new StorageName();
        $storageAdd->name = $request->storage;
        $storageAdd->save();

        return view('storage_add');
    }



    public function boxFillingShow(){
        return view('box_filling');
    }

    public function boxFillingAdd(Request $request){
        Box::create([
            'storage_id' => $request->storage,
            'nomenklature_id' => $request->nomenklature,
            'field' => $request->field,
            'quautity' => $request->quantity
        ]);
        return view('box_filling');
    }

    public function boxDisssemblyShow($id){

        return view('/box_disassembly', ['id' => $id]);

    }

    public function boxSamplingShow($id){

        return view('/box_sampling', ['id' => $id]);
    }


    public function boxDisssemblyAdd(SamplingProcent $request){

        //использованна собственная проверка запроса
        $request->all();


//return view('test', ['request' => $request])->wit;
        Disassembly::create([
            'box_id' => $request->id,
            'f50' => $request->f50,
            'f40' => $request->f40,
            'f30' => $request->f30,
            'notStandart' => $request->notStandart,
            'waste' => $request->waste,
            'land' => $request->land


        ]);
        return redirect()->route('box_filling')->withInput();
    }

    public function boxSamplingAdd(Request $request){
        Sampling::create([
            'box_id' => $request->id,
            'f50' => $request->f50,
            'f40' => $request->f40,
            'f30' => $request->f30,
            'notstandart' => $request->notStandart,
            'waste' => $request->waste,
            'land' => $request->land,
            'decline' => $request->declaine,
            'comment' => $request->comment

        ]);
        return redirect()->route('box_filling');
    }

    public function boxItog(){
        foreach (Box::all() as $value){


            $sampling = Sampling::
                    selectRaw('sum(f50) as f50')
                ->selectRaw('sum(f40) as f40')
                ->selectRaw('sum(f30) as f30')
                ->selectRaw('sum(waste) as waste')
                ->selectRaw('sum(land) as land')
                ->selectRaw('sum(decline) as decline')
                ->selectRaw('sum(notstandart) as notstandart')
                ->where('box_id', $value->id)->get();

            if (Disassembly::where('box_id', $value->id)->orderby('created_at', 'desc')->limit(1)->exists()){
                $disassembly = Disassembly::where('box_id', $value->id)->orderby('created_at', 'desc')->limit(1)->get();
            $box_itog [] = [
                'SP50' => round($sampling[0]->f50/$value->quautity*100),
                'SV50' => round($sampling[0]->f50),
                'SP40' => round($sampling[0]->f40/$value->quautity*100),
                'SV40' => round($sampling[0]->f40),
                'SP30' => round($sampling[0]->f30/$value->quautity*100),
                'SV30' => round($sampling[0]->f30),
                'SPnotStandart' => round($sampling[0]->notstandart/$value->quautity*100),
                'SVnotStandart' => round($sampling[0]->notstandart),
                'SPwaste' => round($sampling[0]->waste/$value->quautity*100),
                'SVwaste' => round($sampling[0]->waste),
                'SPland' => round($sampling[0]->land/$value->quautity*100),
                'SVland' => round($sampling[0]->land),
                'SPdeclaine' => round($sampling[0]->decline/$value->quautity*100),
                'SVdeclaine' => round($sampling[0]->decline),

                'comment' => Sampling::where('box_id', $value->id)->where('comment','<>',null)->orderby('created_at', 'desc')->limit(1)->value('comment'),

                'DP50' => round($disassembly[0]->f50),
                'DP40' => round($disassembly[0]->f40),
                'DP30' => round($disassembly[0]->f30),
                'DPnotStandart' => round($disassembly[0]->notstandart),
                'DPwaste' => round($disassembly[0]->waste),
                'DPland' => round($disassembly[0]->land),
                'DV50' => round($value->quautity/100*$disassembly[0]->f50),
                'DV40' => round($value->quautity/100*$disassembly[0]->f40),
                'DV30' => round($value->quautity/100*$disassembly[0]->f30),
                'DVnotStandart' => round($value->quautity/100*$disassembly[0]->notstandart),
                'DVwaste' => round($value->quautity/100*$disassembly[0]->waste),
                'DVland' => round($value->quautity/100*$disassembly[0]->land),
                'storagebox' => StorageName::where('id', $value->storage_id)->value('name'),
                'field' => $value->field,
                'quautity' => $value->quautity,
                'nomenklature' => Nomenklature::where('id', $value->nomenklature_id)->value('name'),
                'id' => $value->id
            ];

        }
        }

        $i = 0;
        foreach ($box_itog as $value) {
            foreach ($value as $item => $key){
                if ($key === 0 or $key === 0.0){
                    $box_itog[$i][$item] = null;
                }
                if ($key < 100 and $key > 0 and $item <> 'id'){
                    $box_itog[$i][$item] = $key . '%';
                }
            }
            $i++;

        }

        return view('box_itog', ['itogs' => $box_itog]);

    }

    public function storageDetail($id){

        $storageDetail = Disassembly::where('box_id', $id)->get();
        $storageid = Box::find($id);

        return view('storagedetail', ['storageDetail' => $storageDetail, 'storageid' => $storageid]);
    }
}
