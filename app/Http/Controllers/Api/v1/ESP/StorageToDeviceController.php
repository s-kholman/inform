<?php

namespace App\Http\Controllers\Api\v1\ESP;

use App\Http\Controllers\Controller;
use App\Models\DeviceESP;
use Illuminate\Http\Request;

class StorageToDeviceController extends Controller
{
    public function __invoke(Request $request)
    {
        $device = DeviceESP::query()
            ->where('storage_name_id', $request->storage_id)
            ->first();

        if (empty($device)){
            return response()->json(['message' => 'empty']);
        } else{
            return response()->json(['message' => $device->id]);
        }


    }
}
