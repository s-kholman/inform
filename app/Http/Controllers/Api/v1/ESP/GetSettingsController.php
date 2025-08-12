<?php

namespace App\Http\Controllers\Api\v1\ESP;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetSettingsRequest;
use App\Models\DeviceESP;
use App\Models\DeviceESPSettings;
use Illuminate\Http\Request;

class GetSettingsController extends Controller
{
    public function __invoke(GetSettingsRequest $request)
    {
        return DeviceESPSettings::query()
            ->where('device_e_s_p_id', $request->deviceESP_id)
            ->get()
            ;
    }
}
