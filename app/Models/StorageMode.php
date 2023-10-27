<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageMode extends Model
{
    use HasFactory;
    protected $fillable = ['timeUp','timeDown','product_monitoring_id'];

    public function StorageName()
    {
        return $this->belongsTo(ProductMonitoring::class,'product_monitoring_id','id');
    }
}
