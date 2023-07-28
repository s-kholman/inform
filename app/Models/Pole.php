<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pole extends Model
{
    protected $fillable = ['name','filial_id','path','poliv'];

    public function filial(){
        return $this->belongsTo(filial::class);
    }

    public function Poliv(){
        return $this->belongsTo(Poliv::class);
    }

}
