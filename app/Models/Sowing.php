<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sowing extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'sowing_last_name_id',
            'cultivation_id',
            'filial_id',
            'shift_id',
            'sowing_type_id',
            'machine_id',
            'harvest_year_id',
            'sowing_outfit_id',
            'date',
            'volume'
        ];

    public function sowingOutfit(): BelongsTo
    {
        return $this->belongsTo(SowingOutfit::class);
    }

}
