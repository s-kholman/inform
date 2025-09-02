<?php

namespace App\Http\Controllers\Api\v1\ESP;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetSettingsRequest;
use App\Http\Resources\DeviceESPSettingGetResource;
use App\Http\Resources\DeviceESPSettingsResource;
use App\Models\DeviceESP;
use App\Models\DeviceESPSettings;
use App\Models\DeviceESPUpdate;
use App\Models\DeviceThermometer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class GetSettingsController extends Controller
{
    public function __invoke(GetSettingsRequest $request)
    {
        $usedPoint = DB::table('device_thermometers')
            ->select('temperature_point_id')
            ->where('device_e_s_p_id', $request->id)
            //->where('temperature_point_id', '<>', null)
        ;

        $point = DB::table('temperature_points')
            ->select('id', 'name')
            ->whereNotIn('id', $usedPoint)
            ->orderBy('name')
            ->get()

        ;

        $deviceActivation = DeviceESP::query()
            //->select('status')
            ->find($request->id);

        $deviceSettings = DeviceESPSettings::query()
            ->where('device_e_s_p_id', $request->id)
            ->with(['deviceThermometer', 'deviceESPUpdate', 'deviceThermometer.TemperaturePoint'])
            ->first()
            ;

        $deviceSettingsSend ['correction_ads'] = $deviceSettings->correction_ads ?? 0;

        $deviceUpdate = $deviceSettings->deviceESPUpdate ?? null;

        if (empty($deviceUpdate)){
            $arrayPoint ['deviceUpdate'] = ['message' => "Настройки прошивки не найдены"];
        } else{
            $arrayPoint ['deviceUpdate'] = $deviceUpdate->toArray();
        }

        if (empty($deviceSettings)){
            $deviceSettingsSend ['message'] = "Настройки не найдены";
        } else{
            $deviceSettingsSend = $deviceSettings->toArray();
        }

        if (empty($point)){
            $arrayPoint ['point'] = ['message' => "Настройки не найдены"];
        } else{
            $arrayPoint ['point'] = $point->toArray();
        }

        if (empty($deviceActivation)){
            $arrayPoint ['deviceActivation'] = ['message' => "Настройки не найдены"];
        } else{
            $arrayPoint ['deviceActivation'] = $deviceActivation->toArray();
        }




        $array = array_merge($deviceSettingsSend, $arrayPoint);
        //return Response::json($ret);

        return Response::json($array);
        //return $ret;
       return DeviceESPSettingGetResource::collection($ret);
    }
}
