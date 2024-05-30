<?php

namespace App\Http\Controllers;

use App\Actions\Acronym\AcronumLastName;
use App\Http\Requests\CrudOneRequest;
use App\Http\Requests\SowingLastNameRequest;
use App\Models\filial;
use App\Models\SowingLastName;
use Illuminate\Support\Str;

class SowingLastNameController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - ФИО',
        'label' => 'Введите ФИО',
        'route' => 'sowingLastName'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sowingLastNames = SowingLastName::query()
            ->with('filial')
            ->get()
            ->sortBy(['filial.name', 'name'])
        ;

        return view('sowingLastName.index', ['sowingLastNames'=>$sowingLastNames]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filials = filial::query()->get();
        return view('sowingLastName.create', ['filials' => $filials]);
    }

    /**
     * Store a newly created resource in storagebox.
     */
    public function store(SowingLastNameRequest $request, AcronumLastName $acronumLastName)
    {

        if ($request->hasFile('image')) {
            $fo = fopen($request->file('image'), "r+");
           while (!feof($fo)){
               $str = fgets($fo, 4096);
               $filial_id_to = Str::afterLast($str, "\t");
               $last_name = Str::headline(Str::before($str, "\t"));
               if($acronumLastName->Acronym($last_name) <> false){
                   SowingLastName::query()
                       ->updateOrCreate(
                           [
                               'name' => preg_replace('/[^яА-Я0-9. ]/ui', '',$acronumLastName->Acronym($last_name)),
                           ],
                           [
                               'filial_id' => $this->filialTo($filial_id_to),
                           ]
                       );
               }
           }
            return redirect()->route(self::TITLE['route'].'.index');
        }

        $validated = $request->validated();
        SowingLastName::query()->create([
            'name' => $validated['sowingLastName'],
            'filial_id' => $validated['filial'],
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SowingLastName $sowingLastName)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SowingLastName $sowingLastName)
    {
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$sowingLastName]);
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(CrudOneRequest $request, SowingLastName $sowingLastName)
    {
        $validated = $request->validated();
        $sowingLastName->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(SowingLastName $sowingLastName)
    {
        $sowingLastName->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }

    private function filialTo($id)
    {
        switch ($id) {
            case '000000005':
                return 11;
            case '000000084':
                return 12;
            case '000000013':
                return 2;
            case '000000053':
                return 7;
            case '000000083':
                return 5;
            case '000000049':
                return 13;
            case '000000050':
                return 4;
            case '000000048':
                return 3;
            case '000000010':
                return 1;
        }
    }

}
