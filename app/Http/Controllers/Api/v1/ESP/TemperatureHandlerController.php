<?php

namespace App\Http\Controllers\Api\v1\ESP;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TemperatureHandlerController extends Controller
{
    /*
     * Получаем JSON
     * Первый пункт API или MAC, идентифицировать устройство
     * Дальше массив с SN термометров и данными с них
     * */
    public function __invoke(Request $request): JsonResponse
    {
        Log::info($request->post());
        return response()->json(
            [
                'message' => true
            ]
        )->setStatusCode(200);
    }
}
