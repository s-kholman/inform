<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Models\DeviceESP;
use App\Models\DeviceESPSettings;
use App\Models\DeviceThermometer;
use App\Models\ProductMonitoringDevice;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

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
                [
                    'mac' => $this->data['mac']
                ],
            );
        return $this;
    }

    public function render(): JsonResponse
    {
        //Log::info(count($this->data));
        //if (array_key_exists('temperature', $this->data)){
        if (count($this->data) > 2 && ($this->modelESP->device_operating_code == 1 || $this->modelESP->device_operating_code == 2 || $this->modelESP->device_operating_code == 3)) {
            $this->store();
        } elseif (array_key_exists('thermometer', $this->data) && $this->modelESP->device_operating_code == 4) {

            $this->storeThermometerSerialNumber($this->data['thermometer']);

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
            ->first();

        $thermometers = DeviceThermometer::query()
            ->where('device_e_s_p_id', $this->modelESP->id)
            ->pluck('serial_number');

        /*
         * Формируем первоначальный JSON настроек
         * */
        $this->settings['update'] = $settings->update_status ?? false;
        $this->settings['thermometer_get_sn'] = false;
        $this->settings['temperature_get'] = false;
        $this->settings['humidity_get'] = false;
        $this->settings['key_get'] = false;
        $this->settings['activate_code'] = $this->modelESP->activate_code ?? 0;

        if ($settings->update_status) {
            $this->settings['fingerprint'] = '520f6fd0b3234e7530e7c0c7102fbcffe75701ae';
            $this->settings['update_url'] = $settings->deviceESPUpdate->url;
            DeviceESPSettings::query()
                ->where('device_e_s_p_id', $this->modelESP->id)
                ->update(['update_status' => false]);
        } elseif ($this->modelESP->device_operating_code == 1) {
            $this->settings['temperature_get'] = true;
            $this->settings['thermometer'] = $thermometers;

        } elseif ($this->modelESP->device_operating_code == 4) {
            $this->settings['thermometer_get_sn'] = true;

        } elseif ($this->modelESP->device_operating_code == 2) {
            $this->settings['humidity_get'] = true;

        } elseif ($this->modelESP->device_operating_code == 3) {
            $this->settings['humidity_get'] = true;
            $this->settings['temperature_get'] = true;
            $this->settings['thermometer'] = $thermometers;
        }
    }

    private function store(): void
    {
        $harvest = new HarvestAction();
        $point = [];
        $humidity = null;
        $temperature_humidity = null;

        if (($this->modelESP->device_operating_code == 1 || $this->modelESP->device_operating_code == 3) && array_key_exists('temperature', $this->data)) {
            // Log::info('temperature');
            $thermometers = DeviceThermometer::query()
                ->select(['temperature_point_id', 'serial_number', 'calibration'])
                ->with('TemperaturePoint')
                ->where('device_e_s_p_id', $this->modelESP->id)
                ->get()
                ->groupBy('serial_number')
                ->toArray();

            foreach ($this->data['temperature'] as $serial_number => $temperature) {
                if (array_key_exists($serial_number, $thermometers)) {
                    $point [$thermometers[$serial_number][0]['temperature_point']['pointTable']] = $temperature + $thermometers[$serial_number][0]['calibration'];
                    Log::info("calibration " . $thermometers[$serial_number][0]['serial_number'] . ' ('. $thermometers[$serial_number][0]['calibration'] . ') = ' . $temperature + $thermometers[$serial_number][0]['calibration']);
                }
            }
        }

        if (($this->modelESP->device_operating_code == 2 || $this->modelESP->device_operating_code == 3) && array_key_exists('humidity', $this->data)) {
            $humidity = $this->data['humidity'] ?? null;
            if ($humidity > 100) {
                $humidity = null;
            }
            $temperature_humidity = $this->data['humidity_t'] ?? null;
        }

        //Переписываем измерения на устройстве если активирован 13 градусник

        if (!empty($point[13])){
            $temperature_humidity = $point[13];
        }

        //!empty($point) &&
        if ($this->modelESP->storage_name_id <> null && (array_key_exists('humidity', $this->data) || array_key_exists('temperature', $this->data))) {
            ProductMonitoringDevice::query()
                ->create(
                    [
                        'storage_name_id' => $this->modelESP->storage_name_id,
                        'temperature_point_one' => $point[1] ?? null,
                        'temperature_point_two' => $point[2] ?? null,
                        'temperature_point_three' => $point[3] ?? null,
                        'temperature_point_four' => $point[4] ?? null,
                        'temperature_point_five' => $point[5] ?? null,
                        'temperature_point_six' => $point[6] ?? null,
                        'temperature_point_seven' => $point[7] ?? null,
                        'temperature_point_eight' => $point[8] ?? null,
                        'temperature_point_nine' => $point[9] ?? null,
                        'temperature_point_ten' => $point[10] ?? null,
                        'temperature_point_eleven' => $point[11] ?? null,
                        'temperature_point_twelve' => $point[12] ?? null,
                        'temperature_humidity' => $temperature_humidity, //(!$temperature_humidity == 300) ? $temperature_humidity : null,
                        'humidity' => $humidity,//(!$humidity == 300) ? $humidity : null,
                        'harvest_year_id' => $harvest->HarvestYear(now(), 7),
                        'device_e_s_p_id' => $this->modelESP->id,
                        'adc' => $this->adsToVoltage($this->data['ADC'] ?? null),
                        'rssi' => $this->data['RSSI'] ?? null,
                        'device_e_s_p_update_id' => null,
                    ]
                );
            $this->settings['messages'] = 'Ok';
        } else {
            $this->settings['messages'] = 'Нет данных для сохранения';
        }
    }

    public function storeThermometerSerialNumber($serial_number)
    {
        //$request = new Illuminate\Http\Request($test_array);
        //Log::info($serial_number);

        //if (strlen($serial_number) === 20 || strlen($serial_number) === 19){
        // $r = preg_match('/^[0-9]+$/u', $serial_number);
        // if ($r){
        DeviceThermometer::query()
            ->updateOrCreate(
                [
                    'serial_number' => $serial_number
                ]
            );
        // $r = 'YES';
        // } else{
        //     $r = 'NO';
        // }
        //} else{
        //    $r = 'NO';
        //}


        $this->settings['thermometer_store'] = "message";
        //app('log')->info("storeThermometerSerialNumber - ", $serial_number);
    }

    private function adsToVoltage($ads): float|null
    {

        if (is_numeric($ads)) {
            $correct_ads = DeviceESPSettings::query()->where('device_e_s_p_id', $this->modelESP->id)->first();
            //Log::info($correct_ads->correction_ads);

            if (empty($correct_ads->correction_ads)) {
                return null;
            } else {
                $correct_ads = $correct_ads->correction_ads;
            }
            return round(4.2 / $correct_ads * $ads, 2);
        }
        return null;
    }
}
