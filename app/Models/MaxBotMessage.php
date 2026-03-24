<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaxBotMessage extends Model
{
    protected $fillable =
        [
            'max_user_id',
            'max_chat_id',
            'timestamp',
            'message',
        ];
}
