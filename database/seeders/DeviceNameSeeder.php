<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceNameSeeder extends Seeder
{
    static $name =[
        ['id' => 1, 'name' =>	"ECOSYS M2035dn", 'brend_id' =>	1],
['id' => 2, 'name' =>	"ECOSYS M2040dn", 'brend_id' =>	1],
['id' => 3, 'name' =>	"ECOSYS M2540dn", 'brend_id' =>	1],
['id' => 4, 'name' =>	"ECOSYS M2735dn", 'brend_id' =>	1],
['id' => 5, 'name' =>	"ECOSYS M3145dn", 'brend_id' =>	1],
['id' => 6, 'name' =>	"ECOSYS P2040dn", 'brend_id' =>	1],
['id' => 7, 'name' =>	"FS-1035MFR", 'brend_id' =>	1],
['id' => 8, 'name' =>	"M1212nf MFP", 'brend_id' =>	2],
['id' => 9, 'name' =>	"MFP M435", 'brend_id' =>	2],
['id' => 10, 'name' =>	"LaserJet P2035n", 'brend_id' =>	2],
['id' => 11, 'name' =>	"M1217nfw MFP", 'brend_id' =>	2],
['id' => 12, 'name' =>	"ECOSYS P2335", 'brend_id' =>	1],
['id' => 13, 'name' =>	"P1606dn", 'brend_id' =>	2],
['id' => 14, 'name' =>	"P1505n", 'brend_id' =>	2],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$name as $value){
            DB::table('device_names')->insert([
                'id' => $value['id'],
                'name' => $value['name'],
                'brend_id' => $value['brend_id']
            ]);
        }
    }
}
