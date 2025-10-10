<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceESPSettingsRequest;
use App\Models\DeviceESP;
use App\Models\DeviceESPSettings;
use App\Models\DeviceESPUpdate;
use App\Models\DeviceOperatingMode;
use App\Models\DeviceThermometer;
use App\Models\StorageName;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class DeviceESPSettingsController extends Controller
{
    public function show(): Response
    {
        $devices = DeviceESP::query()->with('storageName')->get()->sortBy('storageName.name');

        $storageNames = StorageName::query()->get();

        $thermometers = DeviceThermometer::query()
            ->where('device_e_s_p_id', null)
            ->orderBy('serial_number')
            ->get()
            ;

        $updateBin = DeviceESPUpdate::query()
            ->get();

        $device_operating_code = DeviceOperatingMode::query()->get();

        return response()->view('esp.show',
            [
                'devices' => $devices,
                'thermometers' => $thermometers,
                'storageNames' => $storageNames,
                'updateBin' => $updateBin,
                'device_operating_code' => $device_operating_code,
            ]);
    }

    public function store(DeviceESPSettingsRequest $request)//: RedirectResponse
    //public function store(Request $request): RedirectResponse
    {
        DeviceESP::query()
            ->where('id', $request->deviceESP)
            ->update(
                [
                    //'status' => boolval($request->deviceActivate),
                    'device_operating_code' => $request->device_operating_code,
                    'description' => $request->description,
                    'storage_name_id' => $request->storageName,
                    'activate_code' => $request->activate_code,
                ]);

        if ($request->thermometers <> null){
            DeviceThermometer::query()
                ->where('serial_number', $request->thermometers)
                ->update(
                    [
                        'device_e_s_p_id' => $request->deviceESP,
                        'temperature_point_id' => $request->pointSelect
                    ]
                );
        }


        DeviceESPSettings::query()
            ->updateOrCreate(
                ['device_e_s_p_id' => $request->deviceESP],
                [
                    'update_status' => $request->update_status,
                    'device_e_s_p_updates_id' => $request->updateBin,
                    'correction_ads' => $request->correction_ads,
                ]
            );

        return \response()->redirectTo('esp/settings');
    }
}
