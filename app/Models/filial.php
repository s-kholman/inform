<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\svyaz;


class filial extends Model
{
    protected $fillable = ['name'];
    public function Pole(){
        return $this->hasMany(Pole::class);
    }

    public function Registration(){
        return $this->hasMany(Registration::class);
    }

}
