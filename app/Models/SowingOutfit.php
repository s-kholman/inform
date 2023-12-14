<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SowingOutfit extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'sowing_last_name_id',
            'filial_id',
            'sowing_type_id',
            'machine_id',
            'harvest_year_id',
            'active'
        ];

    public function SowingLastName()
    {
        return $this->belongsTo(SowingLastName::class);
    }

}
