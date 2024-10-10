<?php

use App\Http\Controllers\Api\v1\ProductMonitoringController;
use Illuminate\Support\Facades\Route;

Route::get('productMonitoring/{id?}/{date?}', [ProductMonitoringController::class, 'index']);
