<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceESP extends Model
{
    use HasFactory;

    protected $fillable = [
        'mac',
        'description',
        'storage_name_id',
        'status',
    ];
}
