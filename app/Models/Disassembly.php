<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disassembly extends Model
{
    protected $fillable = ['box_id', 'f50', 'f40', 'f30', 'notStandart', 'waste', 'land'
];
}
