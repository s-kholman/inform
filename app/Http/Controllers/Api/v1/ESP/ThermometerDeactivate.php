<?php

namespace App\Http\Controllers\Api\v1\ESP;

use App\Http\Controllers\Controller;
use App\Models\DeviceThermometer;
use Illuminate\Http\Request;

class ThermometerDeactivate extends Controller
{
    public function __invoke(Request $request)
    {
        DeviceThermometer::query()
            ->where('serial_number', $request->serial_number)
            ->update(
                [
                    'device_e_s_p_id' => null,
                    'temperature_point_id' => null
                ]);

        return response()->json(['message' => 'Ok']);
    }
}
