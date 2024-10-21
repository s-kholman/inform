<?php

namespace App\Http\Controllers;

use App\Models\ProductMonitoringControl;
use Illuminate\Support\Facades\Auth;

class ProductMonitoringControlController extends Controller
{
    public function __invoke($modelCreateOrUpdate, $store)
    {
        if (array_key_exists('control_manager',$store) && Auth::user()->hasRole('ProductMonitoring.director')) {
            ProductMonitoringControl::query()
                ->create([
                    'product_monitoring_id' => $modelCreateOrUpdate->id,
                    'user_id' => Auth::user()->id,
                    'level' => 1,
                    'text' => $store['control_manager']
                ]);
        } elseif (array_key_exists('control_director',$store) && Auth::user()->hasRole('ProductMonitoring.deploy')) {
            ProductMonitoringControl::query()
                ->create([
                    'product_monitoring_id' => $modelCreateOrUpdate->id,
                    'user_id' => Auth::user()->id,
                    'level' => 2,
                    'text' => $store['control_director']
                ]);
        }
    }
}
