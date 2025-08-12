<?php

namespace App\Http\Controllers;

use App\Models\DeviceESP;
use App\Models\DeviceESPSettings;
use App\Models\DeviceThermometer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeviceESPSettingsController extends Controller
{
    public function show(): Response
    {
        $devices = DeviceESP::query()->get();

        $thermometers = DeviceThermometer::query()
            ->where('used', false)
            ->get()
            ;

        return response()->view('esp.show', ['devices' => $devices, 'thermometers' => $thermometers]);
    }

    public function store(Request $request): RedirectResponse
    {

        DeviceESPSettings::query()
            ->updateOrCreate(
                ['device_e_s_p_id' => $request->deviceESP],
                [
                    'update_status' => $request->update_status,
                    'update_url' =>$request->update_url ,
                    'thermometers' =>json_encode($request->thermometers),
                ]
            );
        return \response()->redirectTo('esp/settings');
    }
}
