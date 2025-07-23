<?php

namespace Database\Seeders;

use App\Models\TermPrinterSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TermPrinterSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TermPrinterSettings::query()
            ->create([
                'ip_address' => '192.168.0.69',
                'filial_id' => 1,
                'description' => 'Упоровский',
            ]);
    }
}
