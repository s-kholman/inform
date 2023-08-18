<?php

namespace App\Http\Controllers;

use App\Actions\Printer\IndexAction;
use App\Models\CurrentStatus;
use App\Models\DailyUse;
use App\Models\Device;
use App\Models\Service;
use Carbon\Carbon;
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
        return view('printer.service.index', ['const' => self::TITLE, 'device' => $device]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storagebox.
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
    public function show(IndexAction $indexAction)
    {
        $device = $indexAction(Carbon::now());

        $result = $device['result'];
        foreach ($device['device'] as $id => $value) {

            $ff = $value->DeviceNames->toArray();
            $filial = $value->filial->name;


            $countToServiceDay = Service::
            whereHas('DeviceNames', function ($query) {
                $query->where('brend_id', 1);})->
            with('DeviceNames')->
            where('device_id', $value->device_id)->
            latest('date')->take(1)->get();

            if ($countToServiceDay->isNotEmpty() && $ff['0']['brend_id'] == 1) {
                $count = DailyUse::
                where('date', '<=', $countToServiceDay[0]->date)->
                where('device_id', $value->device_id)->
                latest('date')->
                take(1)->
                get();

                if ($count->isNotEmpty()) {
                    $serviceCount [] = ['count' => $result[$id]['count'] - $count[0]->count, 'device' => $value->device_id, 'filial' => $filial];
                }
            } elseif ($ff['0']['brend_id'] == 1) {
                $serviceCount [] = ['count' => $result[$id]['count'], 'device' => $value->device_id, 'filial' => $filial];

            }
        }

        $collection = collect($serviceCount);

        $already = $collection->filter(function ($value, $key) {

            return $value['count'] >= 20000;
        });
        $soon = $collection->filter(function ($value, $key) {
            return $value['count'] >= 15000 and $value['count'] < 20000;
        });
        $itog = $already->merge($soon);


return view('printer.service.service', ['itog' =>$itog]);





    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storagebox.
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
        /**
         * Не нашел аналога ф-ии "lead", использовал сырой запрос
         */
        $sql = DB::table('daily_uses')
            ->select('date', 'count')
            ->selectRaw(' toner - lead(toner) OVER (order by date) AS itog ')
            ->where('device_id', $device->id)
            ->get();
        $cartridge = $sql->where('itog', '<', -1)->where('itog', '<>', null)->sortByDesc('date');
        return view('printer.service.toner', ['cartridge' => $cartridge]);
    }

}
