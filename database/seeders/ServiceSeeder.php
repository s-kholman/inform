<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    static $info = [
['id' => 1, 'device_id' =>	5, 'sevice_names_id' => 10, 'date' =>	"2022-05-24", 'filial_id' =>	1],
['id' => 2, 'device_id' =>	13, 'sevice_names_id' => 	1, 'date' =>	"2021-08-31", 'filial_id' =>	2],
['id' => 3, 'device_id' =>	13, 'sevice_names_id' =>	1, 'date' =>	"2022-04-26", 'filial_id' =>	2],
['id' => 4, 'device_id' =>	14, 'sevice_names_id' =>	1, 'date' =>	"2022-02-28", 'filial_id' =>	3],
['id' => 5, 'device_id' =>	15, 'sevice_names_id' =>	1, 'date' =>	"2022-03-31", 'filial_id' =>	4],
['id' => 6, 'device_id' =>	2, 'sevice_names_id' =>	1, 'date' =>	"2021-11-30", 'filial_id' =>	5],
['id' => 7, 'device_id' =>	20, 'sevice_names_id' =>	1, 'date' =>	"2022-04-30", 'filial_id' =>	6],
['id' => 8, 'device_id' =>	11, 'sevice_names_id' =>	1, 'date' =>	"2021-08-31", 'filial_id' =>	7],
['id' => 9, 'device_id' =>	3, 'sevice_names_id' =>	1, 'date' =>	"2022-03-31", 'filial_id' =>	9],
['id' => 10, 'device_id' =>	7, 'sevice_names_id' =>	1, 'date' =>	"2022-01-31", 'filial_id' =>	10],
['id' => 11, 'device_id' =>	17, 'sevice_names_id' =>	1, 'date' =>	"2022-05-01", 'filial_id' =>	11],
['id' => 12, 'device_id' =>	16, 'sevice_names_id' =>	1, 'date' =>	"2022-05-01", 'filial_id' =>	20],
['id' => 13, 'device_id' =>	10, 'sevice_names_id' =>	1, 'date' =>	"2022-02-01", 'filial_id' =>	18],
['id' => 14, 'device_id' =>	18, 'sevice_names_id' =>	1, 'date' =>	"2021-08-31"	, 'filial_id' =>21],
['id' => 15, 'device_id' =>	18, 'sevice_names_id' =>	2, 'date' =>	"2022-02-01", 'filial_id' =>	21],
['id' => 16, 'device_id' =>	18, 'sevice_names_id' =>	3, 'date' =>	"2022-02-01", 'filial_id' =>	21],
['id' => 17, 'device_id' =>	18, 'sevice_names_id' =>	5, 'date' =>	"2022-03-01", 'filial_id' =>	21],
['id' => 18, 'device_id' =>	16, 'sevice_names_id' =>	5, 'date' =>	"2022-06-06", 'filial_id' =>	20],
['id' => 19, 'device_id' =>	14, 'sevice_names_id' =>	5, 'date' =>	"2022-06-08", 'filial_id' =>	3],
['id' => 20, 'device_id' =>	14, 'sevice_names_id' =>	1, 'date' =>	"2022-06-08", 'filial_id' =>	3],
['id' => 21, 'device_id' =>	22, 'sevice_names_id' =>	11, 'date' =>	"2022-06-23", 'filial_id' =>	12],
['id' => 22, 'device_id' =>	18, 'sevice_names_id' =>	12, 'date' =>	"2022-06-29", 'filial_id' =>	21],
['id' => 24, 'device_id' =>	5, 'sevice_names_id' =>	1, 'date' =>	"2022-08-04", 'filial_id' =>	1],
['id' => 25, 'device_id' =>	5, 'sevice_names_id' =>	6, 'date' =>	"2022-08-04", 'filial_id' =>	1],
['id' => 26, 'device_id' =>	5, 'sevice_names_id' =>	7, 'date' =>	"2022-08-04", 'filial_id' =>	1],
['id' => 27, 'device_id' =>	28, 'sevice_names_id' =>	8, 'date' =>	"2022-08-04", 'filial_id' =>	16],
['id' => 28, 'device_id' =>	7, 'sevice_names_id' =>	1, 'date' =>	"2022-08-10", 'filial_id' =>	10],
['id' => 29, 'device_id' =>	2, 'sevice_names_id' =>	1, 'date' =>	"2022-08-31", 'filial_id' =>	5],
['id' => 30, 'device_id' =>	2, 'sevice_names_id' =>	6, 'date' =>	"2022-08-31", 'filial_id' =>	5],
['id' => 31, 'device_id' =>	15, 'sevice_names_id' =>	5, 'date' =>	"2022-03-01", 'filial_id' =>	4],
['id' => 32, 'device_id' =>	11, 'sevice_names_id' =>	1, 'date' =>	"2022-09-02", 'filial_id' =>	7],
['id' => 33, 'device_id' =>	11, 'sevice_names_id' =>	5, 'date' =>	"2022-09-02", 'filial_id' =>	7],
['id' => 34, 'device_id' =>	2, 'sevice_names_id' =>	4, 'date' =>	"2022-09-08", 'filial_id' =>	16],
['id' => 38, 'device_id' =>	13, 'sevice_names_id' =>	6, 'date' =>	"2022-09-28", 'filial_id' =>	16],
['id' => 39, 'device_id' =>	13, 'sevice_names_id' =>	1, 'date' =>	"2022-09-28", 'filial_id' =>	16],
['id' => 41, 'device_id' =>	7, 'sevice_names_id' =>	1, 'date' =>	"2022-09-12", 'filial_id' =>	2],
['id' => 42, 'device_id' =>	21, 'sevice_names_id' =>	1, 'date' =>	"2022-06-01", 'filial_id' =>	17],
['id' => 44, 'device_id' =>	16, 'sevice_names_id' =>	1, 'date' =>	"2022-06-06", 'filial_id' =>	8],
['id' => 46, 'device_id' =>	8, 'sevice_names_id' =>	1, 'date' =>	"2022-10-20", 'filial_id' =>	20],
['id' => 47, 'device_id' =>	9, 'sevice_names_id' =>	1, 'date' =>	"2022-10-20", 'filial_id' =>	8],
['id' => 48, 'device_id' =>	14, 'sevice_names_id' =>	1, 'date' =>	"2022-10-20", 'filial_id' =>	3],
['id' => 49, 'device_id' =>	15, 'sevice_names_id' =>	1, 'date' =>	"2022-10-20", 'filial_id' =>	4],
['id' => 50, 'device_id' =>	4, 'sevice_names_id' =>	1, 'date' =>	"2022-10-20", 'filial_id' =>	5],
['id' => 51, 'device_id' =>	3, 'sevice_names_id' =>	1, 'date' =>	"2022-11-10", 'filial_id' =>9],
['id' => 52, 'device_id' =>3, 'sevice_names_id' =>	6, 'date' =>	"2022-11-10"	, 'filial_id' =>9],
['id' => 53, 'device_id' =>	3, 'sevice_names_id' =>	7, 'date' =>	"2022-11-10", 'filial_id' =>	9],
['id' => 55, 'device_id' =>	17, 'sevice_names_id' =>	1, 'date' =>	"2022-11-10", 'filial_id' =>	11],
['id' => 56, 'device_id' =>	4, 'sevice_names_id' =>	1, 'date' =>	"2022-12-27", 'filial_id' =>	5],
['id' => 57, 'device_id' =>	4, 'sevice_names_id' =>	6, 'date' =>	"2023-01-09", 'filial_id' =>	5],
['id' => 58, 'device_id' =>	20, 'sevice_names_id' =>	2, 'date' =>	"2023-01-11", 'filial_id' =>	6],
['id' => 59, 'device_id' =>	20, 'sevice_names_id' =>	3, 'date' =>	"2023-01-11", 'filial_id' =>	6],
['id' => 60, 'device_id' =>	19, 'sevice_names_id' =>	13, 'date' =>	"2023-01-12", 'filial_id' =>	15],
['id' => 61, 'device_id' =>	15, 'sevice_names_id' =>	6, 'date' =>	"2023-01-12", 'filial_id' =>	4],
['id' => 62, 'device_id' =>	15, 'sevice_names_id' =>	1, 'date' =>	"2023-01-12"	, 'filial_id' =>4],
['id' => 63, 'device_id' =>	17, 'sevice_names_id' =>	1, 'date' =>	"2023-02-07", 'filial_id' =>	11],
['id' => 64, 'device_id' =>	17, 'sevice_names_id' =>	5, 'date' =>	"2023-02-07", 'filial_id' =>	11],
['id' => 65, 'device_id' =>	17, 'sevice_names_id' =>	6, 'date' =>	"2023-02-07"	, 'filial_id' =>11],
['id' => 66, 'device_id' =>	14, 'sevice_names_id' =>	6, 'date' =>	"2023-02-17", 'filial_id' =>	3],
['id' => 67, 'device_id' =>	14, 'sevice_names_id' =>	1, 'date' =>	"2023-02-17"	, 'filial_id' =>3],
['id' => 68, 'device_id' =>	4, 'sevice_names_id' =>	1, 'date' =>	"2023-04-29", 'filial_id' =>	5],
['id' => 69, 'device_id' =>	5, 'sevice_names_id' =>	6, 'date' =>	"2023-05-18", 'filial_id' =>	1],
['id' => 70, 'device_id' =>	14, 'sevice_names_id' =>	1, 'date' =>	"2023-06-09", 'filial_id' =>	3],
['id' => 71, 'device_id' =>	5, 'sevice_names_id' =>	11, 'date' =>	"2023-06-16", 'filial_id' =>	16],
['id' => 72, 'device_id' =>	29, 'sevice_names_id' =>	1, 'date' =>	"2023-06-30", 'filial_id' =>	10],
['id' => 73, 'device_id' =>	17, 'sevice_names_id' =>	1, 'date' =>	"2023-07-13", 'filial_id' =>	11],
['id' => 74, 'device_id' =>	18, 'sevice_names_id' =>	1, 'date' =>	"2023-08-04", 'filial_id' =>	21],
['id' => 75, 'device_id' =>	18, 'sevice_names_id' =>	6, 'date' =>	"2023-08-04", 'filial_id' =>	21],
['id' => 76, 'device_id' =>	15, 'sevice_names_id' =>	1, 'date' =>	"2023-08-04", 'filial_id' =>	4],
['id' => 77, 'device_id' =>	11, 'sevice_names_id' =>	1, 'date' =>	"2023-08-04", 'filial_id' =>7],
    ];

     /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$info as $value){
            DB::table('services')->insert([
                'id' => $value['id'],
                'device_id' => $value['device_id'],
                'service_names_id' => $value['sevice_names_id'],
                'date' => $value['date'],
                'filial_id' => self::toId($value['filial_id']),
            ]);
        }
    }

    private function toId ($id)
    {

        switch ($id)
        {
            case 1:
                return 1;
            case 2:
                return 2;
            case 3:
                return 68;
            case 4:
                return 69;
            case 5:
                return 70;
            case 6:
                return 4;
            case 7:
                return 71;
            case 8:
                return 72;
            case 9:
                return 73;
            case 10:
                return 74;
            case 11:
                return 75;
            case 12:
                return 76;
            case 13:
                return 77;
            case 14:
                return 78;
            case 15:
                return 79;
            case 16:
                return 80;
            case 17:
                return 3;
            case 18:
                return 81;
            case 19:
                return 82;
            case 20:
                return 83;
            case 21:
                return 86;
            case 22:
                return 84;
            case 23:
                return 85;
            case 24:
                return 87;
            case 25:
                return 5;
            case 26:
                return 88;


        }
    }

}
