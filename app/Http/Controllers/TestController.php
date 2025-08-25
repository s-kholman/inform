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

dd($_SERVER['SERVER_NAME']);

        $settings = DeviceESPSettings::query()
            ->with('deviceESPUpdate')
            ->where('device_e_s_p_id', 1)
            ->first()
        ;

        dump($settings->deviceESPUpdate->url);
        dd($settings);
        /**/

        $data = [
            "temperature" =>
               ["18031439798487315240" => 24.8125],
               ["17238757885560118056" => 25.25],
               ["14284435012912183080" => 25.375]
        ];

/*        $data = [
            "temperature" =>
            []
        ];*/

        /*$thermometers = DeviceThermometer::query()
            ->select(['temperature_point_id', 'serial_number'])
            ->with('TemperaturePoint')
            ->where('device_e_s_p_id',1)
            ->get()
            ->groupBy('serial_number')
            ->toArray()
        ;
        $point = [];
        dump($thermometers);
        foreach ($data as $value)
        {
            foreach ($value as $serial_number => $temperature)
            {
                dump($value);
                if (array_key_exists($serial_number, $thermometers)){
                    $point [$thermometers[$serial_number][0]['temperature_point']['pointTable']] = $temperature;
                }

            }

           // dump($pointTable);
            //
           // $id = $thermometers->where('serial_number', $thermometer)->first()->temperature_point_id ?? 0;
            //$point [$pointTable] = $value[0];
        }*/

        dump($point);
        dd('stop');
    }
}
