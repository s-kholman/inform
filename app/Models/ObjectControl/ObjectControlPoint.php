<?php

namespace App\Models\ObjectControl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ObjectControlPoint extends Model
{
    protected $fillable =
        [
            'name',
            'object_type_id',
        ]
    ;

    public function objectType(): BelongsTo
    {
        return $this->belongsTo(ObjectType::class);
    }
}
