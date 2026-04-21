<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceWarningTemperatureStorageRequest;
use App\Models\DeviceWarningTemperatureStorage;
use App\Models\StorageName;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class DeviceWarningTemperatureStorageController extends Controller
{

    public function index(): Response
    {

        $role = Role::query()
            ->with('Users.Registration')
            ->where('name', 'LIKE', 'MessageSendFilial_%')
            ->get();

        $storageName = StorageName::query()
            ->get()
            ->sortBy('name')
        ;

        $deviceWarningTemperatureStorage = DeviceWarningTemperatureStorage::query()
            ->with(['storageName', 'role'])
            ->get()
            ->sortBy('storageName.name')
        ;

        return response()->view('production_monitoring.device.warningTemperature.index',
            [
                'storageName' => $storageName,
                'deviceWarningTemperatureStorage' => $deviceWarningTemperatureStorage,
                'role' => $role,
            ]
        );
    }

    public function store (DeviceWarningTemperatureStorageRequest $request): RedirectResponse
    {
        DeviceWarningTemperatureStorage::query()
            ->updateOrCreate(
                [
                    'storage_name_id' => $request->storageName,
                ],
                [
                    'role_id' => $request->role,
                    'temperature_max' => $request->temperatureMax,
                    'temperature_min' => $request->temperatureMin,
                    'active' => $request->boolean('active'),
                ]
            );

        return \response()->redirectTo('device/warning/temperature/storage');
    }

    public function destroy(DeviceWarningTemperatureStorage $storage): JsonResponse
    {
        $storage->delete();

        return response()->json(['status'=>true,"redirect_url"=>url('device/warning/temperature/storage')]);
    }
}
