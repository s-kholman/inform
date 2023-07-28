<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $fillable = ['smsText', 'phone', 'smsType', 'smsActive'];
}
