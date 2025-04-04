<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarmingRequest;
use App\Models\StorageName;
use App\Models\Warming;
use Illuminate\Support\Facades\Auth;

class WarmingController extends Controller
{
    public function index()
    {
        $warming = Warming::query()
            ->with(['storageName'])
            ->get()

        ;

        $t = $warming->collect()->groupBy('storageName.filial_id');

        return view('warming.index', ['warming' => $t]);
    }

    public function create()
    {
        $storage_name = StorageName::query()->where('filial_id', Auth::user()->Registration->filial_id)->get();
        return view('warming.create', ['storage_name' => $storage_name]);
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
                'comment_deputy_director' => $warmingRequest['comment_agronomist'],
            ]);
        return redirect()->route('warming.index');
    }
}
