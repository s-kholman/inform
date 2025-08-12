<?php

namespace App\Http\Controllers;

use App\Models\ProductMonitoringDevice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductMonitoringDeviceController extends Controller
{
    public function show(): Response
    {
        $monitoring = ProductMonitoringDevice::query()
            ->get();
        return response()->view('production_monitoring.device.show', ['monitoring' => $monitoring]);
    }
}
