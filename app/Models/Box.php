<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $fillable = ['storage_id', 'nomenklature_id', 'field', 'quautity'];
}
