<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermPrinterSettings extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable =
    [
        'ip_address',
        'filial_id',
        'description',
    ];

}
