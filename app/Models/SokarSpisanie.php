<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SokarSpisanie extends Model
{
    use HasFactory;
    protected $fillable = ['sokar_f_i_o_s_id','sokar_sklad_id','count','date'];

    public function SokarSklad()
    {
        //return $this->hasOne(SokarSklad::class, 'id', 'sokar_id')
    }

    public function SokarFIO()
    {
        return $this->hasOne(SokarFIO::class, 'id', 'sokar_f_i_o_s_id');
    }

    public function sizes()
    {
        return $this->through('sklad')->has( 'size');
    }

    public function rost()
    {
        return $this->through('sklad')->has( 'rost');
    }

    public function colors()
    {
        return $this->through('sklad')->has( 'color');
    }

    public function sklad()
    {
        return $this->hasOne(SokarSklad::class, 'id', 'sokar_sklad_id');
    }

    public function nomeklature()
    {
        return $this->through('sklad')->has('SokarNomenklat');
       // return $this->through('Sevooborot')->has('Reproduktion');
    }
}
