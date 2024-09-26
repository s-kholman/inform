<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoragePhaseTemperature extends Model
{
    protected $fillable = ['storage_phase_id', 'temperature_min', 'temperature_max'];

    use HasFactory;

    public function storagePhase () {
        return $this->belongsTo(StoragePhase::class);
    }

}
