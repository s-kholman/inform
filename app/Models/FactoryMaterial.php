<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactoryMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['date','filial_id','fio','nomenklature_id','photo_path','user_id'];

    public function filial ()
    {
        return $this->belongsTo(filial::class);
    }

    public function nomenklature ()
    {
        return $this->belongsTo(Nomenklature::class);
    }

    public function gues ()
    {
       return $this->hasOne(FactoryGues::class, 'factory_material_id', 'id');
    }
}
