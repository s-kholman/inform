<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Warming extends Model
{
    use HasFactory;

    protected $fillable = [
        'storage_name_id',
        'volume',
        'warming_date',
        'sowing_date',
        'comment',
        'harvest_year_id',
    ];

    public function storageName(): HasOne
    {
        return $this->hasOne(StorageName::class, 'id', 'storage_name_id');
    }

    public function warmingControl(): HasMany
    {
       return $this->hasMany(WarmingControl::class);
    }

    public function HarvestYear(): BelongsTo
    {
        return $this->belongsTo(HarvestYear::class);
    }
}
