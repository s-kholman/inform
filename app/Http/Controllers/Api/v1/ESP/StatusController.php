<?php

namespace App\Http\Controllers\Api\v1\ESP;

use App\Http\Controllers\Controller;
use App\Http\Requests\ESPStatusRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class StatusController extends Controller
{
    public function __invoke(ESPStatusRequest $ESPStatusRequest): JsonResponse
    {
        /*
         * Имитация для тестирования железа
         * */

            Log::info($ESPStatusRequest->mac . ' Прошел валидацию');
            return response()->json(
                [
                    'update' => true,
                    'update_url' => 'https://develop.krimm.ru/storage/app/esp/update/Temerature_v1.ino.bin',
                    'temperature' => true,
                    'settings' => true,
                    'settings_parameter' => ['parameter_1' => '1', 'parameter_2' => '2', ],
                    'voltage' => true,
                ])->setStatusCode(200);
    }
}
