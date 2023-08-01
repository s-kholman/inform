<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nomenklature extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'kultura_id'];

    public function Kultura(){
        return $this->belongsTo(Kultura::class);
    }

    //Создаю как стандарт в зависимые справочники для получения доступа в blade шаблоне
    public function ParrentName()
    {
        return $this->hasOne(Kultura::class,'id','kultura_id');
    }

    public function Sevooborot(){
        return $this->hasMany(Sevooborot::class);
    }
}
