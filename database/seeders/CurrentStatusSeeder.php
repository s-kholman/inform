<?php

namespace Database\Seeders;

use App\Models\CurrentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (CurrentStatus::all() as $value){
            $value->update([
                'device_names_id' => $value->device->device_names_id
            ]);
        }
    }
}
