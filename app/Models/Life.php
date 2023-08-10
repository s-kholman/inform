<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Life extends Model
{
    protected $connection = 'pgsql_printer';
    protected $table = 'life';
    use HasFactory;

}
