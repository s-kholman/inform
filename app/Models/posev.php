<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posev extends Model
{
    protected $fillable = ['fio_id', 'kultura_id', 'sutki_id', 'filial_id', 'agregat_id', 'vidposeva_id', 'svyaz_id','posevDate', 'posevGa'];

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

    public function kultura(){
        return $this->belongsTo(Kultura::class);
    }

    public function sutki(){
        return $this->belongsTo(Sutki::class);
    }


}
