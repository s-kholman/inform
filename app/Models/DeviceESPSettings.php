<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DeviceESPSettings extends Model
{
    use HasFactory;
    protected $fillable = [
        'device_e_s_p_id',
        'update_status',
        'device_e_s_p_updates_id',
        'correction_ads',
    ];

    public function deviceThermometer(): HasMany
    {
        return $this->hasMany(DeviceThermometer::class, 'device_e_s_p_id', 'device_e_s_p_id');
    }

    public function deviceESPUpdate(): BelongsTo
    {
        return $this->belongsTo(DeviceESPUpdate::class, 'device_e_s_p_updates_id', 'id');
    }
}
