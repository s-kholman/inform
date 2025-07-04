<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationDescription extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'description',
            'application_id',
            'user_id',
        ];
}
