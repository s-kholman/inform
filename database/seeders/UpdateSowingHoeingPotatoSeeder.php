<?php

namespace Database\Seeders;

use App\Models\SowingHoeingPotato;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateSowingHoeingPotatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = ['hoeing_result_agronomist', 'hoeing_result_director', 'hoeing_result_deputy_director'];

        foreach ($positions as $position){
            $update = SowingHoeingPotato::query()
                ->where($position, '!=', null)
                ->get();

            foreach ($update as $value){
                $value->update([
                    $position.'_point_1' => $value->$position
                ]);
            }
        }


    }
}
