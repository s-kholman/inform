<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Take extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['storage_box_id','fifty','forty','thirty','standard','waste','land','date','user_id','comment'];
}
