<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Models\DeviceESP;
use App\Models\DeviceESPSettings;
use App\Models\DeviceThermometer;
use App\Models\HarvestYear;
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
            ->where('device_e_s_p_id', $this->modelESP->id)
            ->first()
            ;

        $thermometers = DeviceThermometer::query()
           // ->select('serial_number')
            ->where('device_e_s_p_id', $this->modelESP->id)
            ->pluck('serial_number')
            //->toJson()
        ;


        $this->settings['update'] = $settings->update_status;

        if ($settings->update_status){
            $this->settings['fingerprint'] = '520f6fd0b3234e7530e7c0c7102fbcffe75701ae';
                $this->settings['update_url'] = $settings->update_url;
            } else{
            $this->settings['temperature'] = true;
                //$this->settings['thermometer'] = json_decode($settings->thermometers);
                $this->settings['thermometer'] =$thermometers;
            }

    }

    private function store()//: void
    {
/*        $thermometers = json_decode($this->data['temperature']);

        foreach ($thermometers as $thermometer => $value){
            $this->settings[$thermometer] = $value;
        }*/
        $harvest = new HarvestAction();
        $point = [];

/*
 *         $thermometes = DeviceThermometer::query()
            ->select('temperature_point_id', 'serial_number')
            ->where('device_e_s_p_id',1)
            ->get()
            ;
        $temp = $thermometes->where('serial_number', '18031439798487315240');
        dd($temp[0]->temperature_point_id);*/

        $thermometers = DeviceThermometer::query()
            ->select(['temperature_point_id', 'serial_number'])
            ->where('device_e_s_p_id',$this->modelESP->id)
            ->get()
            //->toArray();
            ;

         foreach ($this->data['temperature'] as $thermometer => $value)
         {
             $id = $thermometers->where('serial_number', $thermometer)->first()->temperature_point_id ?? 0;
             $point [$id] = $value;

         }

         unset($point [0]);


        if (!empty($point) && $this->modelESP->storage_name_id <> null)
        {
            ProductMonitoringDevice::query()
                ->create(
                    [
                        'storage_name_id' => $this->modelESP->storage_name_id,
                        'temperaturePointOne' => $point[1] ?? 0,
                        'temperaturePointTwo' => $point[2] ?? 0,
                        'temperaturePointThree' => $point[3] ?? 0,
                        'temperatureHumidity' => null,
                        'humidity' => null,
                        'harvest_year_id' => $harvest->HarvestYear(now()),
                        'device_e_s_p_id' => $this->modelESP->id,
                        'ADC' => $this->data['ADC'] ?? 0,
                        'RSSI' => $this->data['RSSI'] ?? null,
                        'version'  => $this->data['version'] ?? null,
                    ]
                );
            $this->settings['messages'] =  'Ok';
        } else{
            $this->settings['messages'] =  'Нет данных для сохранения';
        }


    }


}
