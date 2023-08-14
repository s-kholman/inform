<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageName extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'filial_id'];

    //Создаю как стандарт в зависимые справочники для получения доступа в blade шаблоне
    public function ParrentName()
    {
        return $this->hasOne(filial::class,'id','filial_id');
    }
}
