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
        'status',
    ];

    public function UpdateSetting(): BelongsTo
    {
        return $this->belongsTo(DeviceESPUpdate::class);
    }
}
