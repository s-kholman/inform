<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warming extends Model
{
    use HasFactory;

    protected $fillable = [
        'storage_name_id',
        'volume',
        'warming_date',
        'sowing_date',
        'comment',
    ];

    public function storageName(){
        return $this->hasOne(StorageName::class, 'id', 'storage_name_id');
    }

    public function warmingControl()
    {
       return $this->hasMany(WarmingControl::class);
    }
}
