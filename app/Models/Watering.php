<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Watering extends Model
{
    protected $fillable = ['filial_id', 'pole_id', 'gidrant', 'sector', 'date', 'poliv', 'speed', 'KAC', 'comment','harvest_year_id'];

    public function Pole(): BelongsTo
    {
        return $this->belongsTo(Pole::class);
    }

    public function Filial(): BelongsTo
    {
        return $this->belongsTo(filial::class);
    }

    public function HarvestYear(): BelongsTo
    {
        return $this->belongsTo(HarvestYear::class);
    }
}
