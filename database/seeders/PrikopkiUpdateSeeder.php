<?php

namespace Database\Seeders;

use App\Actions\harvest\HarvestAction;
use App\Models\Prikopki;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrikopkiUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $prikopki = Prikopki::query()->get();
        $harvest_year = new HarvestAction();
        foreach ($prikopki as $value)
        {
            Prikopki::query()
                ->where('id', $value->id)
                ->update([
                    'harvest_year_id' => $harvest_year->HarvestYear($value->date),
                    'production_type' => 1
                ]);
        }

    }
}
