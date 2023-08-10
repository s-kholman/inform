<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ServiceNameSeeder extends Seeder
{
    static $name = [
['id' => 1, 'name' =>	"Чистка бункера отхода"],
['id' => 2, 'name' =>	"Замена ролика подачи"],
['id' => 3, 'name' =>	"Замена ролика отделения"],
['id' => 4, 'name' =>	"Замена тефлоного вала"],
['id' => 5, 'name' =>	"Замена термопленки с тканью"],
['id' => 6, 'name' =>	"Замена фотобарабана"],
['id' => 7, 'name' =>	"Замена Ракеля"],
['id' => 8, 'name' =>	"Ремонт термочки"],
['id' => 9, 'name' =>	"Ремонт узла проявки"],
['id' => 10, 'name' =>	"Чистка бункера и магнит. вала"],
['id' => 11, 'name' =>	"Замена термопленки"],
['id' => 12, 'name' =>	"Ремонт сканера"],
['id' => 13, 'name' =>	"Чистка ролика заряда"],

    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$name as $value){
            DB::table('service_names')->insert([
                'id' => $value['id'],
                'name' => $value['name'],
            ]);
    }
}
}
