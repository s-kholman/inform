<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMonitoring extends Model
{
    use HasFactory;
    protected $fillable = [
        'storage_name_id',
        'date',
        'burtTemperature',
        'burtAboveTemperature',
        'tuberTemperatureMorning',
        'tuberTemperatureEvening',
        'humidity',
        'storage_phase_id',
        'comment',
        'condensate',
        'harvest_year_id',
        'temperature_keeping',
        'humidity_keeping',
        'control_manager',
        'control_director',
    ];

    public function storageName()
    {
        return $this->belongsTo(StorageName::class)->orderBy('name');
    }

    public function phase()
    {
        return $this->hasOne(StoragePhase::class, 'id', 'storage_phase_id');
    }


    public function mode()
    {
        return $this->hasMany(StorageMode::class);
    }

    public function harvestYear()
    {
        return $this->belongsTo(HarvestYear::class);
    }

    public function productMonitoringControl()
    {
        return $this->hasMany(ProductMonitoringControl::class);
    }

    public function Storagefilial()
    {
        return $this->hasOne(StorageName::class, 'id','storage_name_id');
    }

    public function filial()
    {
        return $this->through('Storagefilial')->has('nameFilial');
    }


}
