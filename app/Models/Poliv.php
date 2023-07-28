<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poliv extends Model
{
    protected $fillable = ['filial_id', 'pole_id', 'gidrant', 'sector', 'date', 'poliv', 'speed', 'KAC', 'comment'];

    public function Pole(){
        return $this->belongsTo(Pole::class);
    }
}
