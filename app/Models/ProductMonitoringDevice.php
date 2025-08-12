<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMonitoringDevice extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'storage_name_id',
            'temperaturePointOne',
            'temperaturePointTwo',
            'temperaturePointThree',
            'temperatureHumidity',
            'humidity',
            'harvest_year_id',
            'device_e_s_p_id',
            'ADC',
            'RSSI',
            'version',
        ];
}
