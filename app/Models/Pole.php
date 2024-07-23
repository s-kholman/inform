<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pole extends Model
{
    protected $fillable = ['name','filial_id','path','poliv'];

    public function filial(): BelongsTo
    {
        return $this->belongsTo(filial::class);
    }

    public function nameFilial()
    {
        return $this->hasOne(filial::class,'id','filial_id');
    }

    public function Watering(): BelongsTo
    {
        return $this->belongsTo(Watering::class);
    }

    public function Sevooborot(): HasMany
    {
        return $this->hasMany(Sevooborot::class);
    }


}
