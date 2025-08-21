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
            'temperature_point_one',
            'temperature_point_two',
            'temperature_point_three',
            'temperature_point_four',
            'temperature_point_five',
            'temperature_point_six',
            'temperature_humidity',
            'humidity',
            'harvest_year_id',
            'device_e_s_p_id',
            'adc',
            'rssi',
            'device_e_s_p_update_id',
        ];
}
