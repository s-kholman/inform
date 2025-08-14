<?php

namespace Database\Seeders;

use App\Models\DeviceESP;
use App\Models\DeviceESPSettings;
use App\Models\DeviceThermometer;
use App\Models\TemperaturePoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ESPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $point = [
            'Точка замера 1',
            'Точка замера 2',
            'Точка замера 3',
        ];

        $thermometers = [
            '18031439798487315240',
		    '17238757885560118056',
		    '14284435012912183080'
        ];

        foreach ($point as $value)
        {
            TemperaturePoint::query()
                ->create(
                    [
                        'name' => $value,
                    ]
                )->get();
        }

        foreach ($thermometers as $thermometer){
            DeviceThermometer::query()
                ->create(
                    [
                        'serial_number' => $thermometer
                    ]
                );
        }

        DeviceESP::query()
            ->create(
                [
                    'mac' => '8C:AA:B5:51:0B:E1',
                    'storage_name_id' => 1,
                    'status' => true
                ]
            );

        DeviceESPSettings::query()
            ->create(
                [
                    'device_e_s_p_id' => 1,
                ]
            );
    }
}
