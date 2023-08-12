<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
