<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarmingControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'warming_id',
        'user_id',
        'text',
        'level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
