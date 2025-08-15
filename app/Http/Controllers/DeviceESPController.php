<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Models\DeviceESP;
use App\Models\DeviceESPSettings;
use App\Models\DeviceThermometer;
use App\Models\ProductMonitoringDevice;
use Illuminate\Http\JsonResponse;

class DeviceESPController extends Controller
{
    public $modelESP;
    private array $settings;
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getRequest(): static
    {
        $this->modelESP = DeviceESP::query()
                    ->firstOrCreate(
                        ['mac' => $this->data['mac']],
                    );
        return $this;
    }

    public function render(): JsonResponse
    {
        if (array_key_exists('temperature', $this->data)){
            $this->store();
        } else {
            $this->getSettings();
        }


        return response()->json(
            $this->settings
            )->setStatusCode(200);
    }

    private function getSettings(): void
    {
        $settings = DeviceESPSettings::query()
            ->with('deviceESPUpdate')
            ->where('device_e_s_p_id', $this->modelESP->id)
            ->first()
            ;

        $thermometers = DeviceThermometer::query()
            ->where('device_e_s_p_id', $this->modelESP->id)
            ->pluck('serial_number')
        ;


        $this->settings['update'] = $settings->update_status;

        if ($settings->update_status){
            $this->settings['fingerprint'] = '520f6fd0b3234e7530e7c0c7102fbcffe75701ae';
                $this->settings['update_url'] = $settings->deviceESPUpdate->url;
                DeviceESPSettings::query()
                    ->where('device_e_s_p_id', $this->modelESP->id)
                    ->update(['update_status' => false]);
            } else{
            $this->settings['temperature'] = true;
                //$this->settings['thermometer'] = json_decode($settings->thermometers);
                $this->settings['thermometer'] = $thermometers;
            }

    }

    private function store(): void
    {

        $harvest = new HarvestAction();
        $point = [];

        $thermometers = DeviceThermometer::query()
            ->select(['temperature_point_id', 'serial_number'])
            ->with('TemperaturePoint')
            ->where('device_e_s_p_id',$this->modelESP->id)
            ->get()
            ->groupBy('serial_number')
            ->toArray()
        ;

            foreach ($this->data['temperature'] as $serial_number => $temperature)
            {
                if (array_key_exists($serial_number, $thermometers)){
                    $point [$thermometers[$serial_number][0]['temperature_point']['pointTable']] = $temperature;
                }
            }


        if (!empty($point) && $this->modelESP->storage_name_id <> null)
        {
            ProductMonitoringDevice::query()
                ->create(
                    [
                        'storage_name_id' => $this->modelESP->storage_name_id,
                        'temperaturePointOne' => $point[1] ?? 0,
                        'temperaturePointTwo' => $point[2] ?? 0,
                        'temperaturePointThree' => $point[3] ?? 0,
                        'temperaturePointFour' => $point[4] ?? 0,
                        'temperaturePointFive' => $point[5] ?? 0,
                        'temperaturePointSix' => $point[6] ?? 0,
                        'temperatureHumidity' => null,
                        'humidity' => null,
                        'harvest_year_id' => $harvest->HarvestYear(now()),
                        'device_e_s_p_id' => $this->modelESP->id,
                        'ADC' => $this->data['ADC'] ?? 0,
                        'RSSI' => $this->data['RSSI'] ?? null,
                        'device_e_s_p_update_id'  => null,
                    ]
                );
            $this->settings['messages'] =  'Ok';
        } else{
            $this->settings['messages'] =  'Нет данных для сохранения';
        }
    }
}
