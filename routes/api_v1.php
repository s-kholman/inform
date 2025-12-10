<?php

use App\Http\Controllers\Api\v1\ESP\ConfirmationController;
use App\Http\Controllers\Api\v1\ESP\GetSettingsController;
use App\Http\Controllers\Api\v1\ESP\StatusController;
use App\Http\Controllers\Api\v1\ESP\StorageToDeviceController;
use App\Http\Controllers\Api\v1\ESP\TemperatureHandlerController;
use App\Http\Controllers\Api\v1\ESP\ThermometerDeactivate;
use App\Http\Controllers\Api\v1\IkeVpnController;
use App\Http\Controllers\api\v1\PermissionController;
use App\Http\Controllers\Api\v1\ProductMonitoringController;
use App\Http\Controllers\Api\v1\SevooborotController;
use App\Http\Controllers\Api\v1\SzrController;
use App\Http\Controllers\api\v1\VoucherController;
use App\Http\Controllers\Application\Api\ChangeStatusApplication;
use App\Http\Controllers\Cabinet\Voucher\VoucherSendSmsController;
use App\Http\Controllers\Voucher\VoucherGetToSendController;
use Illuminate\Support\Facades\Route;

Route::get('productMonitoring/{id?}/{date?}', ProductMonitoringController::class);
Route::get('szr/{id?}', SzrController::class);
Route::get('sevooborot/{id?}', SevooborotController::class);
//Route::get('permission/{role}', PermissionController::class);
Route::post('voucher/create', [VoucherController::class, 'voucherCreate']);
Route::post('voucher/get', [VoucherController::class, 'voucherGet']);
Route::post('ike', IkeVpnController::class);
Route::post('cabinetVoucherSmsSend', VoucherSendSmsController::class);
Route::post('cabinetVoucherGetToSend', VoucherGetToSendController::class);
Route::post('change/state/application', ChangeStatusApplication::class);
Route::post('esp/status', StatusController::class);
Route::post('esp/confirmation', ConfirmationController::class);
Route::post('esp/temperature', TemperatureHandlerController::class);
Route::post('esp/get/settings', GetSettingsController::class);
Route::post('esp/thermometer/deactivate', ThermometerDeactivate::class);
Route::post('esp/storage/device/get', StorageToDeviceController::class);
