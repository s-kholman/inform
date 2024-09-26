<?php

namespace Database\Seeders;

use App\Models\StoragePhaseTemperature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoragePhaseTemperatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        StoragePhaseTemperature::query()
            ->create([
                'storage_phase_id' => 2,
                'temperature_min' => 12,
                'temperature_max' => 18,
            ]);

    }
}
