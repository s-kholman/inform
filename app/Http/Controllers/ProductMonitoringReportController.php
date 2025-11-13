<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Models\ProductMonitoring;
use App\Models\ProductMonitoringDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;

class ProductMonitoringReportController extends Controller
{
    public function index (Request $request)
    {
        if (array_key_exists('date', $request->post())){
            $arr_value = ProductMonitoring::query()
                ->where('date', $request->date)
                ->with(['storageName', 'productMonitoringControl', 'filial'])
                ->get();
            $collection = $arr_value->sortBy('storageName.name')->sortBy('filial.name')->groupBy('storageName.filial_id');
            return view('production_monitoring.report.index', ['arr_value' => $collection, 'date' => $request->date, 'show' => 1]);
        } else {
            return view('production_monitoring.report.index', ['date' => now(), 'show' => 0]);
        }
    }

    public function deviceReport (Request $request, HarvestAction $harvestAction)
    {
        if (array_key_exists('date', $request->post())) {
            $dateSelect = $request->date;
            $group_monitoring = $this->reportDevice($request->date);
        } else {
            $dateSelect = now();
            $group_monitoring = $this->reportDevice(now());
        }

       // dd($group_monitoring);
        return view('production_monitoring.device.report.index',
            [
                'date' => $dateSelect,
                'harvest' => $harvestAction->HarvestYear($dateSelect),
                'group_monitoring' => $group_monitoring,
            ]
        );
    }

    private function reportDevice($date)
    {
       return DB::select(
            "select storage_names.name as name, storage_name_id,

                    ROUND(AVG (temperature_point_one)::numeric, 1) as avg_temperature_point_one,
                    ROUND(MAX (temperature_point_one)::numeric, 1) as max_temperature_point_one,
                    ROUND(MIN (temperature_point_one)::numeric, 1) as min_temperature_point_one,
                    ROUND(AVG (temperature_point_two)::numeric, 1) as avg_temperature_point_two,
                    ROUND(MAX (temperature_point_two)::numeric, 1) as max_temperature_point_two,
                    ROUND(MIN (temperature_point_two)::numeric, 1) as min_temperature_point_two,
                    ROUND(AVG (temperature_humidity)::numeric, 1) as avg_temperature_humidity,
                    ROUND(MAX (temperature_humidity)::numeric, 1) as max_temperature_humidity,
                    ROUND(MIN (temperature_humidity)::numeric, 1) as min_temperature_humidity,
                    ROUND(AVG (adc)::numeric, 2) as avg_adc

                    from product_monitoring_devices
                    join storage_names ON storage_names.id = product_monitoring_devices.storage_name_id
                    where product_monitoring_devices.created_at::date = :day

                        group by name, storage_name_id

                           limit 30
                           ", ['day' => $date],
        );
    }
}
