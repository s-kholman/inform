<?php

namespace App\Models\ObjectControl;

use Illuminate\Database\Eloquent\Model;

class ObjectControlImportance extends Model
{
    protected $fillable =
        [
            'name',
            'level',
        ]
    ;
}
