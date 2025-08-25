<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceThermometer extends Model
{
    use HasFactory;
    protected $fillable = [
        'serial_number',
        'used',
    ];

    public function TemperaturePoint(): BelongsTo
    {
        return $this->belongsTo(TemperaturePoint::class);
    }
}
