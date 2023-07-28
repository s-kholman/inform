<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SokarSklad extends Model
{
    use HasFactory;

    protected $fillable = ['sokar_nomenklat_id','size_id','color_id','size_height','count','date','counterpartie_id'];

    public function Color(){
        return $this->hasOne(Color::class, 'id', 'color_id');
    }

    public function Size(){
        return $this->hasOne(Size::class, 'id', 'size_id');
    }

    public function Rost(){
        return $this->hasOne(Size::class, 'id', 'size_height');
    }

    public function Counterparty(){
        return $this->hasOne(Counterparty::class, 'id', 'counterpartie_id');
    }

    public function SokarNomenklat(){
        return $this->hasOne(SokarNomenklat::class, 'id', 'sokar_nomenklat_id');
    }
}
