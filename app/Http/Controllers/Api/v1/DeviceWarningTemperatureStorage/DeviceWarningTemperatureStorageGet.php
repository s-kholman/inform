<?php

namespace App\Http\Controllers\Api\v1\DeviceWarningTemperatureStorage;

use App\Http\Controllers\Controller;
use App\Models\DeviceWarningTemperatureStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeviceWarningTemperatureStorageGet extends Controller
{
    public function __invoke(Request $request)
    {
         $model = DeviceWarningTemperatureStorage::query()
            ->where('storage_name_id', $request->post('storageNameId'))
            ->first()
            ;
         if (!empty($model)){
             return response()->json($model->toArray())->setStatusCode(200);
         } else {
             return response()->json(['message' => 'empty'])->setStatusCode(200);
         }


    }
}
