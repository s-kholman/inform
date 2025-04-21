<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarmingRequest;
use App\Models\StorageName;
use App\Models\Warming;

class WarmingController extends Controller
{
    public function index()
    {
        $warming = Warming::query()
            ->with(['storageName'])
            ->get()

        ;

        $t = $warming->collect()->sortBy('warming_date')->groupBy('storageName.filial_id');

        return view('warming.index', ['warming' => $t]);
    }

    public function create()
    {
        $storage_name = StorageName::query()->get()->sortBy('name');
        return view('warming.create', ['storage_name' => $storage_name]);
    }

    public function edit(Warming $warming)
    {
        return view('warming.edit', ['warming' => $warming]);
    }

    public function update(WarmingRequest $warmingRequest, Warming $warming){
        //dd($warmingRequest['comment']);
        $warming->update(
            [
                'volume' => $warmingRequest['volume'],
                'warming_date' => $warmingRequest['warming_date'],
                'sowing_date' => $warmingRequest['sowing_date'],
                'comment' => $warmingRequest['comment'],
                'comment_agronomist' => $warmingRequest['comment_agronomist'],
                'comment_deputy_director' => $warmingRequest['comment_deputy_director'],
            ]
        );
        return redirect()->route('warming.index');
    }

    public function store(WarmingRequest $warmingRequest)
    {
        Warming::query()
            ->create([
                'storage_name_id' => $warmingRequest['storage_name_id'],
                'volume' => $warmingRequest['volume'],
                'warming_date' => $warmingRequest['warming_date'],
                'sowing_date' => $warmingRequest['sowing_date'],
                'comment' => $warmingRequest['comment'],
                'comment_agronomist' => $warmingRequest['comment_agronomist'],
                'comment_deputy_director' => $warmingRequest['comment_deputy_director'],
            ]);
        return redirect()->route('warming.index');
    }

    public function destroy(Warming $warming)
    {
        $warming->delete();
        return response()->json(['status'=>true,"redirect_url"=>route('warming.index')]);
        //return redirect()->route('warming.index');
    }
}
