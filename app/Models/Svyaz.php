<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\filial;
use App\Models\Vidposeva;

class svyaz extends Model
{
    protected $fillable = ['fio_id', 'filial_id', 'vidposeva_id', 'date', 'active', 'agregat_id'];

    public function filial(){
        return $this->belongsTo(filial::class);
    }

    public function fio(){
        return $this->belongsTo(Fio::class);
    }

    public function vidposeva(){
        return $this->belongsTo( Vidposeva::class);
    }
    public function agregat(){
        return $this->belongsTo( Agregat::class);
    }

}
