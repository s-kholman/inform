<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prikopki extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'filial_id',
        'sevooborot_id',
        'prikopki_square_id',
        'fraction_1',
        'fraction_2',
        'fraction_3',
        'fraction_4',
        'fraction_5',
        'fraction_6',
        'comment',
        'production_type',
        'harvest_year_id',
    ];

    public function Sevooborot()
    {
        return $this->belongsTo(Sevooborot::class);
    }

    public function Filial()
    {
        return $this->belongsTo(filial::class);
    }

    public function PrikopkiSquare(): BelongsTo
    {
        return $this->belongsTo(PrikopkiSquare::class);
    }

    public function HarvestYear(): BelongsTo
    {
        return $this->belongsTo(HarvestYear::class);
    }
}
