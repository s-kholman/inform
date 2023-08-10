<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DeviceName extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'brend_id'
    ];

    //Создаю как стандарт в зависимые справочники для получения доступа в blade шаблоне
    public function ParrentName()
    {
        return $this->hasOne(Brend::class,'id','brend_id');
    }

    public function miboid () : BelongsToMany
    {
        return $this->belongsToMany(MibOid::class);
    }


}
