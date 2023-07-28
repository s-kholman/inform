<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class import extends Model
{
    protected $connection = 'export';
    protected $table = 'posev';
}
