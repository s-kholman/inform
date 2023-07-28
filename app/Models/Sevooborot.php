<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sevooborot extends Model
{
    use HasFactory;

    protected $fillable = ['kultura_id','nomenklature_id','reproduktion_id','pole_id','square','year'];

   /* public function Nomenklature(){
        return $this->belongsTo(Nomenklature::class);
        }*/
    public function Kultura(){
        return $this->hasOne(Kultura::class,'id','kultura_id');
    }

    public function Reproduktion(){
        return $this->hasOne(Reproduktion::class,'id','reproduktion_id');
    }


    public function Nomenklature(){
        return $this->hasOne(Nomenklature::class, 'id','nomenklature_id');
    }
}
