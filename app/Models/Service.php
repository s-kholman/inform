<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['service_names_id','date','device_id','filial_id'];

    public function filial()
    {
        return $this->belongsTo(filial::class);
    }

    public function ServiceName()
    {
        return $this->belongsTo(ServiceName::class, 'service_names_id');
    }

    public function Device() : belongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function temp()
    {
        return $this->hasMany(Device::class, 'id', 'device_id');
    }

    public function DeviceNames ()
    {
       return $this->through('temp')->has('model');
    }
}
