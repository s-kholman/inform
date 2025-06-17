<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Szr extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'szr_classes_id',
        'interval_day_start',
        'interval_day_end',
        'dosage'
    ];

    public function SzrClasses() : BelongsTo
    {
        return $this->belongsTo(SzrClasses::class);
    }


}
