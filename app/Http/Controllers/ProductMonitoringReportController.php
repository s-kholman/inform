<?php

namespace App\Http\Controllers;

use App\Models\ProductMonitoring;
use Illuminate\Http\Request;

class ProductMonitoringReportController extends Controller
{
    public function index ()
    {
        return view('production_monitoring.report.index');
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
