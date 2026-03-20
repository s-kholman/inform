<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class DeviceWarningTemperatureStorage extends Model
{
    protected $fillable =
        [
            'storage_name_id',
            'role_id',
            'temperature_max',
            'temperature_min',
            'active',
        ];

    public function storageName()
    {
        return $this->belongsTo(StorageName::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
