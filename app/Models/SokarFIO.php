<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SokarFIO extends Model
{
    use HasFactory;
    protected $fillable = ['last', 'first', 'middle', 'gender', 'size', 'active'];



}
