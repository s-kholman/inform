<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spraying extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['pole_id','date','sevooborot_id','szr_id','doza','volume','comments','user_id'];

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

    public function Cultivation(){

        return $this->through('Sevooborot')->has('Cultivation');

    }

    public function Polefilial()
    {
        return $this->hasOne(Pole::class, 'id','pole_id');
    }

    public function filial()
    {
        return $this->through('Polefilial')->has('nameFilial');
    }

}
