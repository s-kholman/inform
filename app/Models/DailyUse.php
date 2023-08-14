<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyUse extends Model
{
    use HasFactory;
    protected $fillable = ['device_id','toner','count','date'];

    public function temp()
    {
        return $this->hasMany(Device::class, 'id', 'device_id');
    }

    public function DeviceNames ()
    {
        return $this->through('temp')->has('model');
    }
}
