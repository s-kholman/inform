<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceSeeder extends Seeder
{
    static $DiviceAdd = [
['id' => 1, 'mac' => '00:17:c8:9c:07:51', 'sn' => "VCY0494375", 'date' =>'2022-05-20', 'brend_id' =>	1, 'devece_name_id' =>	6],
['id' => 2, 'mac' => 	"00:c0:ee:dd:6d:91", 'sn' => 	"LVW4735290", 'date' =>	"2022-05-09", 'brend_id' =>	1	, 'devece_name_id' =>	1],
['id' => 3, 'mac' => 	"00:c0:ee:3b:2f:89", 'sn' => 	"LVW4119499", 'date' =>	"2022-05-17", 'brend_id' =>	1, 'devece_name_id' =>	1],
['id' => 4, 'mac' => 	"00:17:c8:3e:df:f1", 'sn' => 	"LVW6330244", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	1],
['id' => 5, 'mac' => 	"00:c0:ee:ba:af:02", 'sn' => 	"LVW3Y00288", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	1],
['id' => 7, 'mac' => 	"00:17:c8:78:2f:94", 'sn' => 	"VCF8X61973", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	2],
['id' => 8, 'mac' => 	"00:17:c8:7b:72:eb", 'sn' => 	"VCF9193543", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	2],
['id' => 9, 'mac' => 	"00:17:c8:77:b0:9a", 'sn' => 	"VCF8X59932", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	2],
['id' => 10, 'mac' => 	"00:17:c8:98:19:d9", 'sn' => 	"VCF9Y41684", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	2],
['id' => 11, 'mac' => 	"00:17:c8:95:da:7a", 'sn' => 	"VCF9830668", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	2],
['id' => 12, 'mac' => 	"00:17:c8:33:3f:2d", 'sn' => 	"VCF7433109", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	2],
['id' => 13, 'mac' => 	"00:17:c8:33:3b:cd", 'sn' => 	"VCF7431789", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	2],
['id' => 14, 'mac' => 	"00:17:c8:b4:e2:71", 'sn' => 	"VCF0Y93777", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	2],
['id' => 15, 'mac' => 	"00:17:c8:9a:cc:13", 'sn' => 	"VCF0258578", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	2],
['id' => 16, 'mac' => 	"00:17:c8:34:ac:d4", 'sn' => 	"VCF7643531", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	2],
['id' => 17, 'mac' => 	"00:17:c8:b5:4f:ba", 'sn' => 	"VCG0Y88094", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	3],
['id' => 18, 'mac' => 	"00:17:c8:7a:19:92", 'sn' => 	"R5M8Z14249", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	4],
['id' => 19, 'mac' => 	"00:17:c8:93:ef:2a", 'sn' => 	"R4Z0331364", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	5],
['id' => 20, 'mac' => 	"00:c0:ee:ac:c1:d0", 'sn' => 	"NR13349914", 'date' =>	"2022-05-23", 'brend_id' =>	1, 'devece_name_id' =>	7],
['id' => 21, 'mac' => 	"00:17:c8:21:a8:74", 'sn' => 	"LVW5Y15823", 'date' =>	"2022-06-01", 'brend_id' =>	1, 'devece_name_id' =>	1],
['id' => 22, 'mac' => 	"14:58:d0:3c:8c:31", 'sn' => 	"NO", 'date' =>	"2022-06-07", 'brend_id' =>	2, 'devece_name_id' =>	10],
['id' => 23, 'mac' => 	"a0:b3:cc:9f:e8:0d", 'sn' => 	"NO", 'date' =>	"2022-06-07", 'brend_id' =>	2, 'devece_name_id' =>	8],
['id' => 24, 'mac' => 	"ec:9a:74:30:11:2e", 'sn' => 	"CNG7CD707M", 'date' =>	"2022-06-07", 'brend_id' =>	2, 'devece_name_id' =>	11],
['id' => 25, 'mac' => 	"00:17:c8:73:43:fc", 'sn' => 	"R5J8301739", 'date' =>	"2022-06-07", 'brend_id' =>	1, 'devece_name_id' =>	12],
['id' => 26, 'mac' => 	"3c:4a:92:ba:cc:af", 'sn' => 	"VNC3B79871", 'date' =>   "2022-06-07", 'brend_id' =>	2, 'devece_name_id' =>	13],
['id' => 27, 'mac' => 	"f4:30:b9:73:a2:90", 'sn' => 	"CNDKKCQD0Y", 'date' =>	"2022-06-07", 'brend_id' =>	2, 'devece_name_id' =>	9],
['id' => 28, 'mac' => 	"00:23:7d:84:4e:46", 'sn' => 	"VNF3C31647", 'date' =>	"2022-08-01", 'brend_id' =>	2, 'devece_name_id' =>	14],
['id' => 29, 'mac' => 	"00:17:c8:d8:4b:27", 'sn' => 	"VCF2145521", 'date' =>	"2022-09-12", 'brend_id' =>	1, 'devece_name_id' =>	2],
['id' => 30, 'mac' => 	"00:1b:78:26:0a:a1", 'sn' => 	"VNC3X01133", 'date' =>	"2022-10-04", 'brend_id' =>	2, 'devece_name_id' =>	14],
['id' => 31, 'mac' => 	"00:17:c8:d8:a4:26", 'sn' => 	"VCY2111371", 'date' =>	"2023-02-01", 'brend_id' =>	1, 'devece_name_id' =>	6],
['id' => 32, 'mac' => 	"00:17:c8:f0:f6:1c", 'sn' => 	"VCF3386763", 'date' =>	"2023-08-03", 'brend_id' =>	1, 'devece_name_id' =>	2]

    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$DiviceAdd as $value){
            DB::table('devices')->insert([
                'id' => $value['id'],
                'mac' => $value['mac'],
                'sn' => $value['sn'],
                'date' => $value['date'],
                'brend_id' => $value['brend_id'],
                'device_names_id' => $value['devece_name_id']
            ]);
        }
    }
}
