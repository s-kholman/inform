<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaxBotUser extends Model
{
    protected $fillable =
        [
            'max_user_id',
            'first_name',
            'last_name',
            'registration_id',
            'description',
        ];
}
