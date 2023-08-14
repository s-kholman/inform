<?php

namespace App\Actions\Printer\device;

use App\Models\Device;

class DeviceСreateAction
{
    public function __invoke($request)
    {
        Device::create([
            'mac' => $request['mac'],
            'sn' => $request['sn'],
            'date' => $request['date'],
            'device_names_id' => $request['device_names_id']
        ]);
    }

}
