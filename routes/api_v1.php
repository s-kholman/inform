<?php

use App\Http\Controllers\api\v1\PermissionController;
use App\Http\Controllers\Api\v1\ProductMonitoringController;
use App\Http\Controllers\Api\v1\SevooborotController;
use App\Http\Controllers\Api\v1\SzrController;
use Illuminate\Support\Facades\Route;

Route::get('productMonitoring/{id?}/{date?}', ProductMonitoringController::class);
Route::get('szr/{id?}', SzrController::class);
Route::get('sevooborot/{id?}', SevooborotController::class);
Route::get('permission/{role}', PermissionController::class);
