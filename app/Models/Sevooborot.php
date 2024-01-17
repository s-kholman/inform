<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sevooborot extends Model
{
    use HasFactory;

    protected $fillable = ['cultivation_id','nomenklature_id','reproduktion_id','pole_id','square','year'];

    public function Cultivation(){
        return $this->hasOne(Cultivation::class,'id','cultivation_id');
    }

    public function Reproduktion(){
        return $this->hasOne(Reproduktion::class,'id','reproduktion_id');
    }


    public function Nomenklature(){
        return $this->hasOne(Nomenklature::class, 'id','nomenklature_id');
    }
}
