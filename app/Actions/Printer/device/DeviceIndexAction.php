<?php

namespace App\Actions\Printer\device;

use App\Models\CurrentStatus;

class DeviceIndexAction
{
    public function __invoke()
    {
        return CurrentStatus::query()
            ->with('status')
            ->get()
            ->sortByDesc('date')
            ->unique('device_id')
            ->sortBy('filial.name')
        ;
    }

}
