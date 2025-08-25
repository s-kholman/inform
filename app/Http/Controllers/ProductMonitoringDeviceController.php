<?php

namespace App\Http\Controllers;

use App\Models\ProductMonitoringDevice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductMonitoringDeviceController extends Controller
{
    public function show(): Response
    {
        $monitoring = ProductMonitoringDevice::query()
            ->orderBy('created_at')
            ->get()
        ;
//$dailyEvents = Event::selectRaw('DATE(created_at) as date, COUNT(*) as count') -> groupBy('date') -> get();
        $group_monitoring = DB::select(
            "select DATE(created_at) as date,
    AVG (temperature_point_one) as avg_temperature_point_one,
    MAX (temperature_point_one) as max_temperature_point_one,
    MIN (temperature_point_one) as min_temperature_point_one,
    AVG (temperature_point_two) as avg_temperature_point_two,
    MAX (temperature_point_two) as max_temperature_point_two,
    MIN (temperature_point_two) as min_temperature_point_two,
    AVG (temperature_point_three) as avg_temperature_point_three,
    MAX (temperature_point_three) as max_temperature_point_three,
    MIN (temperature_point_three) as min_temperature_point_three,
    AVG (temperature_point_four) as avg_temperature_point_four,
    MAX (temperature_point_four) as max_temperature_point_four,
    MIN (temperature_point_four) as min_temperature_point_four,
    AVG (temperature_point_five) as avg_temperature_point_five,
    MAX (temperature_point_five) as max_temperature_point_five,
    MIN (temperature_point_five) as min_temperature_point_five,
    AVG (temperature_point_six) as avg_temperature_point_six,
    MAX (temperature_point_six) as max_temperature_point_six,
    MIN (temperature_point_six) as min_temperature_point_six
                    from product_monitoring_devices
                        group by date
                            order by date"
        )
            ;
dump($group_monitoring);
        return response()->view('production_monitoring.device.show',
            [
                'monitoring' => $monitoring,
                'group_monitoring' => collect($group_monitoring),
            ]);
    }
}
