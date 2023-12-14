<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sowing extends Model
{
    use HasFactory;
    protected $fillable = ['sowing_last_name_id','cultivation_id','filial_id','shift_id','sowing_type_id','machine_id','harvest_year_id','date','volume'];
}
