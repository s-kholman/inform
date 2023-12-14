<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $machine = [
            'EDX',
            'Citan',
            'Ведерштадт',
            'ДМС-601',
            '8 ряд',
            'Клоновая',
            'ГБ 3000',
            'Grimme - 430',
            '4х - рядная',
        ];

        foreach ($machine as $value)
        {
            Machine::query()->create(
                [
                    'name' => $value,
                ]
            );
        }
    }
}
