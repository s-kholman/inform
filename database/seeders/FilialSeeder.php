<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilialSeeder extends Seeder
{
    static $name = [
        "Автопарк",
        "Комерческий",
        "ЦПК",
        "Производственный",
        "Завод по переработке",
        "ХПП",
        "Бухгалтерия",
        "Финансовый",
        "Земельный",
        "Отдел кадров",
        "Агрономы",
        "Приемная",
        "Ремонтная",
        "ТехЦентр",
        "Лаборатория - СОКАР",
        "Строительный отдел",
        "Весовая - ХПП",
        "Весовая - ЗерноКомплекс",
        "Весовая - Производственный",
        "Основной склад З/Ч",
        "Упоровский-МТМ"
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$name as $value){
            DB::table('filials')->insert([
                'name' => $value
            ]);
        }
    }
}
