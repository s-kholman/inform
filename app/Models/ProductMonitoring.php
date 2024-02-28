<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMonitoring extends Model
{
    use HasFactory;
    protected $fillable = ['storage_name_id', 'date', 'burtTemperature', 'burtAboveTemperature', 'tuberTemperatureMorning',
        'tuberTemperatureEvening', 'humidity', 'storage_phase_id','comment', 'condensate'];

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
}
