<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeatExtraction extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'filial_id'];

    public function filial()
    {
        return $this->belongsTo(filial::class);
    }
}
