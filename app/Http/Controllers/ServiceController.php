<?php

namespace App\Http\Controllers;

use App\Models\CurrentStatus;
use App\Models\Device;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    private const TITLE = [
        'title' => 'Справочник - принтера на обслуживании',
        'label' => 'Введите ',
        'route' => 'service'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = CurrentStatus::with('status')->get();
        $device = $status->
        sortByDesc('date')->
        sortByDesc('created_at')->
        unique(['device_id'])->
        sortBy('filial.name')->
        whereNotIn('status.active', true);
        return view('printer.service.index', ['const' => self::TITLE, 'device'=>$device]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Service::create([
            'service_names_id' => $request['service_name'],
            'date' => $request['date'],
            'device_id' => $request['device_id'],
            'filial_id' => $request['filial_id']
        ]);

        return redirect()->route('printer.current.show', ['id' => $request['device_id']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        dd($device);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
    }

    public function device(CurrentStatus $currentStatus)
    {
        return view('printer.service.create', ['currentStatus' => $currentStatus]);
    }

    public function cartridge(Device $device)
    {
        $sql = DB::table('daily_uses')
            ->select('date', 'count')
            ->selectRaw(' toner - lead(toner) OVER (order by date) AS itog ')
            ->where('device_id',  $device->id)
            ->get();
        ;
        $cartridge = $sql->where('itog', '<', -1)->sortByDesc('date');
        return view('printer.service.toner',['cartridge' => $cartridge]);
    }

}
