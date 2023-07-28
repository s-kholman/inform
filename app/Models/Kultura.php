<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kultura extends Model
{
    protected $fillable = ['name', 'vidposeva_id'];

    public function Vidposeva(){
        return $this->belongsTo(Vidposeva::class);
    }
}
