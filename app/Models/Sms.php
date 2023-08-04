<?php

namespace App\Models;

use App\Http\Controllers\RegistrationController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class Sms extends Model
{
    protected $fillable = ['smsText', 'phone', 'smsType', 'smsActive'];
}
