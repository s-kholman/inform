<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
protected $fillable = ['last_name', 'first_name', 'middle_name', 'user_id', 'filial_id', 'post_id', 'phone', 'infoFull'];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function filial(){
        return $this->belongsTo(filial::class);
    }
}
