<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyUse extends Model
{
    use HasFactory;
    protected $fillable = ['device_id','toner','count','date'];
}
