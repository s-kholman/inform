<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StorageName extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'filial_id'];

    public function filial() : BelongsTo
    {
        return $this->belongsTo(filial::class);
    }

    public function nameFilial()
    {
        return $this->hasOne(filial::class,'id','filial_id');
    }
}
