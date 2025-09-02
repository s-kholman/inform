<?php

namespace Database\Seeders;

use App\Models\DeviceESP;
use App\Models\DeviceESPSettings;
use App\Models\DeviceOperatingMode;
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
        $device_operating_modes =
            [
                'Отключено' => 0,
                'Опрос температуры' => 1,
                'Опрос влажности' => 2,
                'Опрос температуры и влажности' => 3,
                'Зарегистрировать градусник' => 4
            ];

        $point = [
            'Точка замера 1',
            'Точка замера 2',
            'Точка замера 3',
            'Точка замера 4',
            'Точка замера 5',
            'Точка замера 6',
            'Точка замера 7',
            'Точка замера 8',
            'Точка замера 9',
            'Точка замера 10',
            'Точка замера 11',
            'Точка замера 12',
        ];

        $thermometers = [
            '18031439798487315240',
		    '17238757885560118056',
		    '14284435012912183080'
        ];

        foreach ($device_operating_modes as $name => $code)
        {
            DeviceOperatingMode::query()
                ->create(
                    [
                        'name' => $name,
                        'code' => $code
                    ]
                );
        }



        $index = 1;
        foreach ($point as $value)
        {
            TemperaturePoint::query()
                ->create(
                    [
                        'name' => $value,
                        'pointTable' => $index
                    ]
                )->get();
            $index++;
        }

        foreach ($thermometers as $thermometer){
            DeviceThermometer::query()
                ->create(
                    [
                        'serial_number' => $thermometer
                    ]
                );
        }

/*        DeviceESP::query()
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
            );*/
    }
}
