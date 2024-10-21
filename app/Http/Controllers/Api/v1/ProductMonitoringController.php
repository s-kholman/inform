<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductMonitoringResource;
use App\Models\ProductMonitoring;
use Illuminate\Http\Request;

class ProductMonitoringController extends Controller
{
    public function __invoke(Request $request): ProductMonitoringResource
    {
        return new ProductMonitoringResource(
            ProductMonitoring::query()
                ->where('storage_name_id', $request->id)
                ->where('date', $request->date)
                ->first());
    }
}
