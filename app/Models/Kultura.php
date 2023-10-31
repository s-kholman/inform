<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kultura extends Model
{
    protected $fillable = ['name', 'vidposeva_id'];

    public function Vidposeva() : BelongsTo
    {
        return $this->belongsTo(Vidposeva::class);
    }
}
