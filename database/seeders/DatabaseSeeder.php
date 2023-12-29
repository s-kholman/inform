<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\SowingLastName;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            [
                SowingTypeSeeder::class,
                SowingLastNameSeeder::class,
                MachineSeeder::class,
                ShiftSeeder::class,
                SowingOutfitSeeder::class,
                SowingSeeder::class,
            ]
        );

    }
}
