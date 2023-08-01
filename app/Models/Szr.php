<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Szr extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'szr_classes_id'];

    //Создаю как стандарт в зависимые справочники для получения доступа в blade шаблоне
    public function ParrentName()
    {
        return $this->hasOne(SzrClasses::class,'id','szr_classes_id');
    }


}
