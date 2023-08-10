<?php

namespace Database\Seeders;

use App\Models\MibOid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MibOidSeeder extends Seeder
{
    static $name = [
        ['id' => 1, 'name' =>	"1.3.6.1.4.1.1347.43.10.1.1.12.1.1", 'comment' =>'Количество страниц отпечатанно kyocera'],
        ['id' => 2, 'name' =>	"1.3.6.1.2.1.43.11.1.1.8.1.1", 'comment' =>'Максимальный уровень тонера kyocera'],
        ['id' => 3, 'name' =>	"1.3.6.1.2.1.43.11.1.1.9.1.1", 'comment' =>'Текущий уровень тонера kyocera'],
        ['id' => 4, 'name' =>	"1.3.6.1.2.1.43.10.2.1.4.1.1", 'comment' =>'Отпечатано страниц всего HP'],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$name as $value) {
          MibOid::create([
                'id' => $value['id'],
                'name' => $value['name'],
                'comment' => $value['comment']
            ]);
        }
    }
}
