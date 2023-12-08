<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peat extends Model
{
    use HasFactory;
    protected $fillable = ['peat_extraction_id','pole_id','filial_id','harvest_year_id','date','volume'];

    public function filial() : BelongsTo
    {
        return $this->belongsTo(filial::class)->orderBy('name');
    }

    public function Pole() : BelongsTo
    {
        return $this->belongsTo(Pole::class);
    }
}
