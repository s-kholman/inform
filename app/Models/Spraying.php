<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spraying extends Model
{
    use HasFactory;
    protected $fillable = ['pole_id','date','sevooborot_id','szr_id','doza','volume','comments'];

    public function Pole(){
        return $this->belongsTo(Pole::class)->orderBy('filial_id');
    }

    public function szr(){
        return $this->belongsTo(Szr::class);
    }

    public function Sevooborot()
    {
        return $this->hasOne(Sevooborot::class, 'id','sevooborot_id');
    }

    public function Nomenklature(){


        return $this->through('Sevooborot')->has('Nomenklature');
    }

    public function Reproduktion(){
        return $this->through('Sevooborot')->has('Reproduktion');
    }

    public function Kultura(){


        return $this->through('Sevooborot')->has('Kultura');
    }


}
