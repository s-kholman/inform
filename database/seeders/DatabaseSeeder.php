<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SzrClassTableSeeder::class);
        // \App\Models\User::factory(10)->сreateDeviceAction();

        // \App\Models\User::factory()->сreateDeviceAction([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
