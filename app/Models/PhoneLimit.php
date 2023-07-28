<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneLimit extends Model
{
    protected $fillable = ['fio','phone','limit','active'];
}
