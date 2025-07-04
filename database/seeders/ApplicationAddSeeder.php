<?php

namespace Database\Seeders;

use App\Models\Application\Application;
use App\Models\Application\ApplicationName;
use App\Models\Application\ApplicationStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationAddSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $applicationStatus =
            [
                10 => 'Зарегистрирована - Ожидайте обработки',
                20 => 'Принята в работу',
                30 => 'Отказ',
                40 => 'Исполнена',
                100 => 'Закрыта'
            ];

        ApplicationName::query()
            ->create([
               'name' => 'Запрос SSL сертификата',
               'factory_name' => 'IKEv2AccessRequestType',
               'description' => 'Запрос сертификата, инициированное пользователем',
            ]);

        foreach ($applicationStatus as $code => $name){
            ApplicationStatus::query()
                ->create([
                    'name' => $name,
                    'status_code' => $code
                ]);
        }
    }
}
