<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SowingLastName extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'filial_id', 'dismissed'];

    public function filial(): BelongsTo
    {
        return $this->belongsTo(filial::class);
    }
}
