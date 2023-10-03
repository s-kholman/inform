<?php

namespace App\Actions\Printer\device;

use App\Models\CurrentStatus;

class DeviceIndexAction
{
    public function __invoke()
    {
        $status = CurrentStatus::with('status')->get();
        return $status->
        sortByDesc('date')->
        unique(['device_id'])->
        sortBy('filial.name');
    }

}
