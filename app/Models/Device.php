<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['id','mac','sn','date','device_names_id'];

    public function modelName()
    {
        return $this->belongsTo(DeviceName::class, 'device_names_id', 'id');
    }

    public function model()
    {
        return $this->hasMany(DeviceName::class, 'id', 'device_names_id');
    }
}
