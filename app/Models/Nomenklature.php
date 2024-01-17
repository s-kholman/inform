<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nomenklature extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cultivation_id'];

    public function Cultivation(){
        return $this->belongsTo(Cultivation::class);
    }

    public function Sevooborot(){
        return $this->hasMany(Sevooborot::class);
    }
}
