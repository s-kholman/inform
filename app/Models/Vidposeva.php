<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vidposeva extends Model
{
    protected $fillable = ['name'];

    public function Kultura(){
        return $this->hasMany(Kultura::class);
    }
}
