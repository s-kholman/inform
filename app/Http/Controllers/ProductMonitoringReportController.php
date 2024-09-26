<?php

namespace App\Http\Controllers;

use App\Models\ProductMonitoring;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

class ProductMonitoringReportController extends Controller
{
    public function index (Request $request)
    {
        //dump($request->post());
        if (array_key_exists('date', $request->post())){
            $arr_value = ProductMonitoring::query()
                ->where('date', $request->date)
                ->with('storageName')
                ->get();
            $collection = $arr_value->sortBy('storageName.name')->sortByDesc('storageName.filial_id')->groupBy('storageName.filial_id');
            return view('production_monitoring.report.index', ['arr_value' => $collection, 'date' => $request->date, 'show' => 1]);
        } else {
            return view('production_monitoring.report.index', ['date' => now(), 'show' => 0]);
        }


    }

    public function today(Request $request)
    {
        $arr_value = ProductMonitoring::query()
            ->where('date', $request->date)
            ->with('storageName')
            ->get();
        $collection = $arr_value->sortBy('storageName.name')->sortByDesc('storageName.filial_id')->groupBy('storageName.filial_id');
        return view('production_monitoring.report.one_date', ['arr_value' => $collection, 'date' => $request->date]);
    }

}
