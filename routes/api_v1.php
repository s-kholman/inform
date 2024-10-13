<?php

use App\Http\Controllers\Api\v1\ProductMonitoringController;
use App\Http\Controllers\Api\v1\SevooborotController;
use App\Http\Controllers\Api\v1\SzrController;
use Illuminate\Support\Facades\Route;

Route::get('productMonitoring/{id?}/{date?}', [ProductMonitoringController::class, 'index']);
Route::get('szr/{id?}', [SzrController::class, 'get']);
Route::get('sevooborot/{id?}', [SevooborotController::class, 'get']);
