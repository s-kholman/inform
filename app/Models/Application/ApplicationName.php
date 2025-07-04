<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationName extends Model
{
    use HasFactory;

    protected $fillable =
        [
          'name',
          'factory_name',
          'description',
        ];
}
