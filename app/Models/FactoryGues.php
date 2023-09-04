<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactoryGues extends Model
{
    use HasFactory;
    protected $fillable = ['factory_material_id', 'volume', 'mechanical', 'land', 'haulm', 'rot', 'foreign_object',
        'another_variety', 'sixty', 'fifty', 'forty', 'thirty', 'less_thirty'];

    public function Material ()
    {
        return $this->hasOne(FactoryMaterial::class,'id','factory_material_id');
    }
}
