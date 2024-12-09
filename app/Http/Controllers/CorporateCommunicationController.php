<?php

namespace App\Http\Controllers;

use App\Models\PhoneDetail;
use App\Models\PhoneLimit;
use Illuminate\Http\Request;

class CorporateCommunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Текущие лимиты
        $limit = PhoneLimit::query()->orderby('fio')->get();

        //Итоговая таблица
        $itogTable = PhoneDetail::query()
            ->orderby('DetailDate', 'DESC')
            ->take(1)
            ->value('DetailViewJSON');

        $toItog = json_decode($itogTable);

        return view('corporateCommunication/index', ['limit' => $limit, 'itogTable' => $toItog]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('corporateCommunication/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        PhoneLimit::query()->updateOrCreate([
            'phone' => $request->phone,
        ], [
                'fio' => $request->fio,
                'limit' => $request->limit,
                'active' => true
            ]
        );
        return redirect()->route('communication.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $detail = PhoneLimit::query()->find($id);
        if (!empty($detail)){
            return view('/corporateCommunication/edit', ['detail' => $detail]);
        } else{
            return redirect()->route('communication.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        PhoneLimit::query()->updateOrCreate([
            'phone' => $request->phone,
        ], [
                'fio' => $request->fio,
                'limit' => $request->limit,
                'active' => true
            ]
        );
        return redirect()->route('communication.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PhoneLimit::query()->where('id', $id)->delete();
        return response()->json(['status'=>true,"redirect_url"=>url('communication')]);
    }
}
