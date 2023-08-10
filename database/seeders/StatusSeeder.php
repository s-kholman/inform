<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    static $info = [
        ['id' => 1, 'name' => 'В работе', 'active' => true],
['id' => 2, 'name' => 	'Ремон', 'active' => false],
['id' => 3, 'name' => 	'Подменный', 'active' => true],
['id' => 4, 'name' => 	'Списан', 'active' => false],
['id' => 5, 'name' => 	'Уничтожен', 'active' => false],
['id' => 6, 'name' => 	'Передача в филиал', 'active' => true],
['id' => 7, 'name' => 	'В резерве (снят с опроса)', 'active' => false],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$info as $value){
           Status::create([
                'id' => $value['id'],
                'name' => $value['name'],
                'active' => $value['active']
            ]);
        }
    }
}
