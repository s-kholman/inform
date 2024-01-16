<?php

namespace Database\Seeders;

use App\Actions\harvest\HarvestAction;
use App\Models\posev;
use App\Models\Sowing;
use App\Models\SowingLastName;
use App\Models\SowingOutfit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(HarvestAction $harvestAction): void
    {
        $posev = posev::query()
//            ->where('vidposeva_id', 1)
//            ->orWhere('vidposeva_id', 2)
            ->get();

        foreach ($posev as $value)
        {
            Sowing::query()->updateOrCreate(
                [
                    'sowing_last_name_id' => self::SowingLastName($value->fio->name)->id,
                    'cultivation_id' => self::toCultivation($value->kultura_id),
                    'filial_id' => $value->filial_id,
                    'shift_id' => $value->sutki_id,
                    'sowing_type_id' => $value->vidposeva_id,
                    'machine_id' => self::toMachine($value->agregat_id),
                    'harvest_year_id' => $harvestAction->HarvestYear($value->posevDate),
                    'sowing_outfit_id' => self::sowingOutfit
                    (
                        self::SowingLastName($value->fio->name)->id,
                        $value->filial_id,
                        $value->vidposeva_id,
                        $harvestAction->HarvestYear($value->posevDate)
                    ),
                    'date' => $value->posevDate,
                ],
                [
                    'volume' => $value->posevGa
                ]
            );
        }
    }

    private function SowingLastName($name)
    {
        return SowingLastName::query()->where('name', $name)->first();
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
            default:
                return null;
        }
    }

    private function toCultivation($id){

        switch ($id) {
            case 1:
                return 1;
            case 2:
                return 2;
            case 3:
                return 7;
            case 4:
                return 3;
            case 5:
                return 4;
            case 6:
                return 6;
            case 8:
                return 5;
            case 9:
                return 8;
            case 10:
                return 9;


        }
    }

    private function sowingOutfit($sowing_last_name_id, $filial_id, $sowing_type_id, $harvest_year_id)
    {
        $id = SowingOutfit::query()
            ->where('sowing_last_name_id', $sowing_last_name_id)
            ->where('filial_id', $filial_id)
            ->where('sowing_type_id', $sowing_type_id)
            ->where('harvest_year_id', $harvest_year_id)
            ->first();

        return $id->id;
    }

}
