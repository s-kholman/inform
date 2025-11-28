<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceThermometerRequest;
use App\Models\DeviceESP;
use App\Models\DeviceThermometer;
use App\Models\TemperaturePoint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeviceThermometerController extends Controller
{
    /*    public function index(): Response
        {

        }*/

    public function create(): Response
    {
        $devices = DeviceESP::query()
            ->get();

        $points = TemperaturePoint::query()
            ->get();

        return response()->view('esp.thermometer.create',
            [
                'devices' => $devices,
                'points' => $points,
            ]
        );
    }

    public function store(DeviceThermometerRequest $request): RedirectResponse
    {

        DeviceThermometer::query()
            ->create(
                [
                    'serial_number' => $request->serial_number
                ]
            );

        return \response()->redirectTo('esp/thermometer/create');
    }

    public function show()
    {
        $thermometers = DeviceThermometer::query()
            ->get()->sortBy('serial_number');

        return response()->view('esp.thermometer.show',
            [
                'thermometers' => $thermometers
            ]
        );
    }

    public function edit(DeviceThermometer $thermometer)
    {
        return response()->view('esp.thermometer.edit',
            [
                'thermometer' => $thermometer
            ]
        );
    }

    public function storeCalibration(Request $request, DeviceThermometer $thermometer)
    {
       // dd($thermometer);
        $thermometer->update([
            'calibration' => $request->calibration,
        ]);

        $thermometers = DeviceThermometer::query()
            ->get()->sortBy('serial_number');

        return response()->view('esp.thermometer.show',
            [
                'thermometers' => $thermometers
            ]
        );
    }
}
