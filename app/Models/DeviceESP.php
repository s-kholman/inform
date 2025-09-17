<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceESP extends Model
{
    use HasFactory;

    protected $fillable = [
        'mac',
        'description',
        'storage_name_id',
        'device_operating_code',
    ];

    public function UpdateSetting(): BelongsTo
    {
        return $this->belongsTo(DeviceESPUpdate::class);
    }

    public function storageName(): BelongsTo
    {
        return $this->belongsTo(StorageName::class);
    }
}
