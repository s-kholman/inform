<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceESPSettings extends Model
{
    use HasFactory;
    protected $fillable = [
        'device_e_s_p_id',
        'update_status',
        'update_url',
    ];

    public function deviceThermometer(): HasMany
    {
        return $this->hasMany(DeviceThermometer::class, 'device_e_s_p_id', 'device_e_s_p_id');
    }
}
