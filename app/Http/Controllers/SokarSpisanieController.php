<?php

namespace App\Http\Controllers;

use App\Models\SokarFIO;
use App\Models\SokarSklad;
use App\Models\SokarSpisanie;
use Illuminate\Http\Request;

class SokarSpisanieController extends Controller
{
    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'integer' => 'Значение не должно быть длинне :max символов',
        'min' => 'Значение не может быть меньше :min',
        'temp.min' => 'Привышает остатки на складе',

    ];




    private const ADD_VALIDATOR = [
        'FIO' => 'required',
        'sklad' => 'required',
        'count' => 'required|integer|min:1',
        'date' => 'required'
    ];

    private const COUNT_VALIDATOR = [
        'temp' => 'required|integer|min:0'
    ];

    private function  display_null($value){

        return $value ?: 'Н/Д';
    }

    private function count($id){

        return SokarSpisanie::where('sokar_sklad_id', $id)->get()->sum('count');

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spisok = [];
        $sklad = [];
        $spisok_get = SokarFIO::where('active', false)->orderby('last')->get();
        foreach ($spisok_get as $value){
            $size = json_decode($value->size);
            $spisok [$value->id] = $value->last .' ' . $value->first . '  ' .
                $value->middle . '   (размеры: ' . $size->shoes . ' / ' . $size->clothes .' / ' . $size->height.')';
        }

        $sklad_get = SokarSklad::where('count', '>', 0)->get();

        foreach ($sklad_get as $value){
            $add_arr = $value->count - SokarSpisanie::where('sokar_sklad_id', $value->id)->get()->sum('count');
            if ($add_arr){
            $sklad [$value->id] = $value->SokarNomenklat->name . '
                (цвет - ' . $this->display_null($value->Color->name ?? null) .
                ' | размер - ' . $this->display_null($value->Size->name ?? null) .
                ' | рост - '. $this->display_null($value->height->name ?? null) .
                ') - остаток = ' . $add_arr;
            }
        }


        //return view('test', ['request' => $spisok]);
        return view('sokar.spisanie', ['spisok' => $spisok, 'sklad' => $sklad]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);
        $temp = SokarSklad::where('id', $request->sklad)->get()->sum('count') - $this->count($request->sklad) - $request->count;
        $request->merge(['temp' => $temp]) ;
        $request->validate(self::COUNT_VALIDATOR, self::ERROR_MESSAGES);

       // return view('test', ['request' => $request]);

       // $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);
       // return view('test', ['request' => $temp]);
        //return redirect('spisanie');
        if ((SokarSklad::where('id', $request->sklad)->get()->sum('count') - $this->count($request->sklad)) >= $request->count) {
            SokarSpisanie::create([
                'sokar_f_i_o_s_id' => $request->FIO,
                'sokar_sklad_id' => $request->sklad,
                'count' => $request->count,
                'date' => $request->date

            ]);
        }




        return redirect('spisanie');
    }

    /**
     * Display the specified resource.
     */
    public function show(SokarSpisanie $sokarSpisanie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SokarSpisanie $sokarSpisanie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SokarSpisanie $sokarSpisanie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SokarSpisanie $sokarSpisanie)
    {
        //
    }

    public function spisanieDate(Request $request)
    {
        $spisanie = SokarSpisanie::whereBetween('date', [$request->dateTo,$request->dateDo])->get();
        return view('sokar.spisanie_date', ['spisanie' => $spisanie, 'dateTo' => $request->dateTo, 'dateDo' => $request->dateDo]);
        //print_r($temp);

    }
}
