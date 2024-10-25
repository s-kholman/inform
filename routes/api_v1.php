<?php

use App\Http\Controllers\api\v1\PermissionController;
use App\Http\Controllers\Api\v1\ProductMonitoringController;
use App\Http\Controllers\Api\v1\SevooborotController;
use App\Http\Controllers\Api\v1\SSLController;
use App\Http\Controllers\Api\v1\SzrController;
use App\Http\Controllers\api\v1\VoucherController;
use Illuminate\Support\Facades\Route;

Route::get('productMonitoring/{id?}/{date?}', ProductMonitoringController::class);
Route::get('szr/{id?}', SzrController::class);
Route::get('sevooborot/{id?}', SevooborotController::class);
Route::get('permission/{role}', PermissionController::class);
Route::post('voucher/create', [VoucherController::class, 'voucherCreate']);
Route::post('voucher/get', [VoucherController::class, 'voucherGet']);
Route::post('ssl/sign', SSLController::class);
