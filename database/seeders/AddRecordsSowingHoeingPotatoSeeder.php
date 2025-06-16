<?php

namespace Database\Seeders;

use App\Actions\harvest\HarvestAction;
use App\Models\Pole;
use App\Models\SowingHoeingPotato;
use App\Models\SowingLastName;
use Illuminate\Database\Seeder;

class AddRecordsSowingHoeingPotatoSeeder extends Seeder
{
    private int $filial = 1;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $harvestAction = new HarvestAction();

        for ($i = 0; $i <=1000; $i++){

        $this->filial = mt_rand(1,3);

        SowingHoeingPotato::query()->create([
            'date' => fake()->dateTimeBetween(strtotime('11 month', time()), time(), null),
            'type_field_work_id' => 2,
            'sowing_last_name_id' => $this->sowingLastName()->id,
            'filial_id' => $this->filial,
            'pole_id' => $this->pole()->id,
            'harvest_year_id' => $harvestAction->HarvestYear(now()),
            'volume' => mt_rand(1,60),
            'shift_id' => mt_rand(1,2),
            'hoeing_result_agronomist_point_1' => $this->hoeingResult(),
            'hoeing_result_agronomist_point_2' => $this->hoeingResult(),
            'hoeing_result_agronomist_point_3' => $this->hoeingResult(),
            'hoeing_result_director_point_1' => $this->hoeingResult(),
            'hoeing_result_director_point_2' => $this->hoeingResult(),
            'hoeing_result_director_point_3' => $this->hoeingResult(),
            'hoeing_result_deputy_director_point_1' => $this->hoeingResult(),
            'hoeing_result_deputy_director_point_2' => $this->hoeingResult(),
            'hoeing_result_deputy_director_point_3' => $this->hoeingResult(),
            'comment' => fake()->realText(25)

]);
        }
    }

    private  function sowingLastName()
    {
        return SowingLastName::query()->inRandomOrder()->first();
    }

    private  function pole()
    {
        return Pole::query()->where('filial_id', $this->filial)->inRandomOrder()->first();
    }

    private  function hoeingResult()
    {
        if (mt_rand(0,1)){
            return mt_rand(1,3);
        } else return null;
    }
}
