<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class CurrentStatus extends Model
{
    use HasFactory;
    protected $fillable = ['id','device_id','hostname','ip','filial_id','status_id','date', 'device_names_id'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function filial()
    {
        return $this->belongsTo(filial::class);
    }

    public function device() : belongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function devicename() : belongsTo
    {
        return $this->belongsTo(DeviceName::class, 'device_names_id', 'id');
    }

    public function temp() : belongsTo
    {
        return $this->belongsTo(DeviceName::class);
    }

    public function brend ()
    {
        return $this->through('temp')->has('ParrentName');
    }




}
