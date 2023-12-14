<?php

namespace App\Actions\harvest;

use App\Models\HarvestYear;
use Illuminate\Support\Carbon;

class HarvestAction
{
    public function HarvestYear($date)
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
}
