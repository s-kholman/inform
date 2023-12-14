<?php

namespace Database\Seeders;

use App\Models\Cultivation;
use App\Models\SowingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SowingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $SowingCultivation = [
            'Зерновые' => [
                'Пшеница',
                'Рапс',
                'Овес',
                'Горох',
                'Соя',
            ],
            'Картофель' => [
                'Картофель',
            ],
            'Овощи' => [
                'Капуста',
                'Свекла',
                'Морковь',
            ],
        ];

        foreach ($SowingCultivation as $Sowing => $Cultivation)
        {
            $id = SowingType::query()->create(
                [
                    'name' => $Sowing,
                ]
            );
            foreach ($Cultivation as $name){
                Cultivation::query()
                    ->create(
                        [
                            'name' => $name,
                            'sowing_type_id' => $id->id,
                        ]
                    );
            }
        }
    }
}
