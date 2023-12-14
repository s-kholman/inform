<?php

namespace Database\Seeders;

use App\Models\SowingLastName;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SowingLastNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lastName = [
            'Арсеньев А.В.',
            'Арсеньев В.А.',
            'Бестужев В. М.',
            'Вяткин С.А.',
            'Гаврилюк С.И.',
            'Деденёв А.А.',
            'Диев П.С.',
            'Колбачев И.А.',
            'Коркин Г. Б.',
            'Кутиков А.Г.',
            'Липихин А.Ф.',
            'Лысов Д.О.',
            'Макаров А.',
            'Макаров А.С.',
            'Маслов С.А.',
            'Медведев И.Г.',
            'Мезенцев Л.Р.',
            'Мохирев В.Л.',
            'Пантрин А.',
            'Перевалов П.Л.',
            'Переладов А. С.',
            'Переладов Д. М.',
            'Плишкин О.М.',
            'Саренов Е.А.',
            'Сединкин А.В.',
            'Семенов К.Л.',
            'Снегирев А.М.',
            'Снегирёв О. В.',
            'Сопин А.Н.',
            'Уфимцев Е. Г.',
            'Харалгин С.Д.',
            'Хлынов С. В.',
            'Худышкин В. А.',
            'Черепанов К.А.',
            'Чернаков Е.В.',
            'Шрайнер Г.А.',
            'Шульц С.В.',
        ];

        foreach ($lastName as $value) {
            SowingLastName::query()->create(
                [
                    'name' => $value,
                ]
            );
        }
    }
}
