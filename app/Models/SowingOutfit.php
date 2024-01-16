<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
            'cultivation_id'
        ];

    public function HarvestYear(): BelongsTo
    {
        return $this->belongsTo(HarvestYear::class);
    }

    public function SowingLastName(): BelongsTo
    {
        return $this->belongsTo(SowingLastName::class);
    }

    public function filial(): BelongsTo
    {
        return $this->belongsTo(filial::class);
    }

    public function SowingType(): BelongsTo
    {
        return $this->belongsTo(SowingType::class);
    }

    public function Machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    public function Cultivation(): BelongsTo
    {
        return $this->belongsTo(Cultivation::class);
    }

    public function Sowings(): HasMany
    {
       return $this->hasMany(Sowing::class);
    }

}
