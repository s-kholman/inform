<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['last_name', 'first_name', 'middle_name', 'user_id', 'filial_id', 'post_id', 'phone', 'infoFull'];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function filial(){
        return $this->belongsTo(filial::class);
    }
}
