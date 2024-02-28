<?php

namespace App\Models\Yandex;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['date','temperature','thermometerName'];
}
