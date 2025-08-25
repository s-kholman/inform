<?php

namespace App\Http\Controllers\Api\v1\ESP;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DeviceESPController;
use App\Http\Requests\ESPStatusRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StatusController extends Controller
{
    public function __invoke(ESPStatusRequest $request): JsonResponse
    {
      app('log')->info("ESP - ", $request->all());
        /*        return response()->json(
          [
              'update' => false,
              'update_url' => 'https://develop.krimm.ru/storage/esp/update/temperature_v1.ino.bin',
              'fingerprint' => '520f6fd0b3234e7530e7c0c7102fbcffe75701ae',
              'temperature' => true,
              'thermometer' => ["18031439798487315240","17238757885560118056"],
              //'settings' => true,
              ///'settings_parameter' => ['parameter_1' => '1', 'parameter_2' => '2', ],
              //'voltage' => true,
          ])->setStatusCode(200);*/

        $device = new DeviceESPController($request->toArray());

        //Создаем или получаем модель контроллера
        $device->getRequest();

        if ($device->modelESP->status){

            return $device->render();

        } else{

            return response()->json(
                [
                    'error' => 'Не готов принимать данные от устройства'
                ]
            )->setStatusCode(200);
        }

    }
}
