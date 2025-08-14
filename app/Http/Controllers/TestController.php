<?php

namespace App\Http\Controllers;

use App\Models\DeviceESPSettings;
use App\Models\DeviceThermometer;
use App\Models\TemperaturePoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function __invoke()
    {
        $ret = DeviceESPSettings::query()
            ->where('device_e_s_p_id', 1)
            ->with('deviceThermometer')
            ->first()
        ;

/*        $point = DeviceThermometer::query()
            ->select('serial_number')
            ->where('device_e_s_p_id', 1)
            ->join('temperature_points', 'temperature_points.id', '<>', 'device_thermometers.temperature_point_id')
            ->get()
            ;*/

        $usedPoint = DB::table('device_thermometers')
            ->select('temperature_point_id')
            ->where('device_e_s_p_id', 1)
            //->where('temperature_point_id', '<>', null)
        ;

        $point = DB::table('temperature_points')
            ->whereNotIn('id', $usedPoint)
            ->orderBy('name')
            ->get()

        ;
        dd($point);

        $point = TemperaturePoint::query()
            ->select('device_thermometers.id as therm', 'temperature_points.id', 'device_e_s_p_id', 'temperature_points.name')
            ->leftJoin('device_thermometers', 'device_thermometers.temperature_point_id', '=', 'temperature_points.id')
            //->where('device_thermometers.device_e_s_p_id', '=', 1)
            //->whereNotIn('device_thermometers.temperature_point_id')
            ->get()

        ;


        dd($point);
    }
}
