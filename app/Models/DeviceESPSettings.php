<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceESPSettings extends Model
{
    use HasFactory;
    protected $fillable = [
        'device_e_s_p_id',
        'update_status',
        'update_url',
        'thermometers',
    ];
}
