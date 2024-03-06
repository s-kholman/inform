<?php

namespace App\Actions\Printer;

use App\Jobs\DailyUseOne;
use App\Models\CurrentStatus;

class PrinterRunSchedule
{
public function __invoke()
{
    $status = CurrentStatus::with('status')->get();
    if($status->isNotEmpty())
    {
        $device = $status->
        sortByDesc('date')->
        sortByDesc('id')->
        unique(['device_id'])->
        sortBy('filial.name')->
        whereNotIn('status.active', false);
        foreach ($device as $value){
            dispatch(new DailyUseOne($value));
        }
    }
}
}
