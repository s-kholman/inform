<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kultura extends Model
{
    protected $fillable = ['name', 'vidposeva_id'];

    public function Vidposeva(){
        return $this->belongsTo(Vidposeva::class);
    }

    //Создаю как стандарт в зависимые справочники для получения доступа в blade шаблоне
    public function ParrentName()
    {
        return $this->hasOne(Vidposeva::class,'id','vidposeva_id');
    }
}
