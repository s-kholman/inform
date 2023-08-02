<?php

namespace App\Http\Controllers;

use App\Models\Spraying;
use Illuminate\Http\Request;

class SprayingReportController extends Controller
{
    public function index(){
       $arr_value = [];
       return view('spraying.report.index', ['arr_value' => $arr_value]);
    }

    public function report(Request $request){
        $arr = [];
        $arr_value = [];

        if ($request->id == 1)
        {
            $arr = Spraying::where('date', $request->date)->get();

        foreach ($arr as $value)
        {
            $arr_value [$value->pole->filial_id] [$value->pole->name] [$value->szr->name] = $value->volume;
        }


        return view('spraying.report.index', ['id' => $request->id, 'arr_value' => $arr_value]);
    } else
        {
            return view('/spraying');
        }

    }
}
