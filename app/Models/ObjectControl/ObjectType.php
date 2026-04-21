<?php

namespace App\Models\ObjectControl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Role;

class ObjectType extends Model
{
    protected $fillable =
        [
            'name',
            'role_id',
        ]
    ;

    public function Role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
