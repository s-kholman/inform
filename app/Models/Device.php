<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $fillable = ['id','mac','sn','date','devece_name_id'];

    public function model() : hasOne
    {
        return $this->hasOne(DeviceName::class);
    }


}
