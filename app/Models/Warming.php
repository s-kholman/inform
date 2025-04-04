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
        'comment_agronomist',
        'comment_deputy_director'
    ];

    public function storageName(){
        return $this->hasOne(StorageName::class, 'id', 'storage_name_id');
    }

    public function Filial()
    {
       // return $this->hasOneThrough(filial::class, /*car*/StorageName::class, 'filial_id', 'id,');
    }
}
