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

    public function Sevooborot(){
        return $this->hasMany(Sevooborot::class);
    }
}
