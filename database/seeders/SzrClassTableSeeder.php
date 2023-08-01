<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SzrClassTableSeeder extends Seeder
{
    static $SzrClassName = [
        'Фунгицид',
        'Инсектицид',
        'Гербицид',
        'Пестицид',
        'Удобрение',
        'Протравитель',
        'Прилипатель',
        'Пеногаситель'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$SzrClassName as $name)
        {
            DB::table('szr_classes')->insert([
                'name' => $name
            ]);
        }
    }
}
