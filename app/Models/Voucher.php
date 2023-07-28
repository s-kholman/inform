<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['phone', 'create_time', 'voucher_code', 'voucher_day', 'voucher_use', 'comment'];
}
