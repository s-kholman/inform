<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleUpdateSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::query()
            ->where('name', 'LIKE', 'DeviceWarningTemperatureStorage%')
            ->orWhere('name', 'LIKE', 'MessageSend%')
            ->orWhere('name', 'LIKE', 'ControlObjectWater%')
            ->orWhere('name', 'LIKE', 'ControlObjectElectricity%')
            ->orWhere('name', 'LIKE', 'ControlObjectGas%')
            ->orWhere('name', 'LIKE', 'objectControllAlarmMessageWater.user%')
            ->delete()
            ;

        $role_description =
            [
                'MessageSendFilial_4.user' => 'Оповещение событий Юргинское',
                'MessageSendFilial_32.user' => 'Оповещение событий ХВР',
                'MessageSendFilial_5.user' => 'Оповещение событий Липиха',
                'MessageSendFilial_11.user' => 'Оповещение событий Хранилище',
                'MessageSendFilial_3.user' => 'Оповещение событий Петропавловка',
                'MessageSendFilial_7.user' => 'Оповещение событий Армизон',
                'MessageSendFilial_8.user' => 'Оповещение событий Автопарк',
                'MessageSendFilial_12.user' => 'Оповещение событий Завод по переработке',
                'MessageSendFilial_26.user' => 'Оповещение событий Зернокомплекс',
                'MessageSendFilial_22.user' => 'Оповещение событий лаборатория - СОКАР',
                'MessageSendFilial_1.user' => 'Оповещение событий Упоровский',
                'MessageSendFilial_2.user' => 'Оповещение событий Затоболье',
                'MessageSendFilial_30.user' => 'Оповещение событий Офис',
                'MessageSendFilial_13.user' => 'Оповещение событий ХПП',
                'MessageSendFilial_21.user' => 'Оповещение событий Тех-центр',
                'DeviceWarningTemperatureStorage.user' => 'Оповещение о температуре в боксе',
                'ControlObjectWater.user' => 'Оповещение, контроль объектов, вода',
                'ControlObjectElectricity.user' => 'Оповещение, контроль объектов, электричество',
                'ControlObjectGas.user' => 'Оповещение, контроль объектов, газ',
                'ControlObjectTemperature.user' => 'Оповещение, контроль объектов, температурный',
            ];

        foreach ($role_description as $key => $value){
            Role::create(
                [
                    'name' => $key,
                    'guard_name' => 'web',
                    'description' => $value,
                ]
            );
        }

    }
}
