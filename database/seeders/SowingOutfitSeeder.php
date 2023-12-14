<?php

namespace Database\Seeders;

use App\Models\HarvestYear;
use App\Models\SowingLastName;
use App\Models\SowingOutfit;
use App\Models\svyaz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SowingOutfitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $svyaz = svyaz::query()
            ->where('vidposeva_id', 1)
            ->orWhere('vidposeva_id', 2)
            ->get();

        foreach ($svyaz as $value){

            SowingOutfit::query()
                ->updateOrCreate(
                [
                    'sowing_last_name_id' => self::toSowingLastName($value)->id,
                    'filial_id' => $value->filial_id,
                    'sowing_type_id' => $value->vidposeva_id,
                    'machine_id' => self::toMachine($value->agregat_id),
                    'harvest_year_id' => self::HarvestYear($value->date) ,
                    'active' =>$value->active,
                ]);
        }

    }

    private function HarvestYear($date)
    {
        if (Carbon::parse($date)->month > 9) {
            return HarvestYear::query()->firstOrCreate(
                [
                    'name' => Carbon::parse($date)->year + 1
                ]
            )->id;
        } else {
            return HarvestYear::query()->firstOrCreate(
                [
                    'name' => Carbon::parse($date)->year
                ]
            )->id;
        }
    }

    private function toSowingLastName(svyaz $svyaz)
    {
        return SowingLastName::query()
            ->where('name', $svyaz->fio->name)
            ->first();


}

    private function toMachine($id)
    {
        switch ($id){
            case 1:
                return 1;
            case 2:
                return 2;
            case 3:
                return 3;
            case 4:
                return 4;
            case 5:
                return 5;
            case 6:
                return 6;
            case 7:
                return 7;
            case 14:
                return 8;
            case 8:
                return 9;


        }
    }
}
