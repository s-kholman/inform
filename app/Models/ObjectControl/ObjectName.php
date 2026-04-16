<?php

namespace App\Models\ObjectControl;

use App\Models\filial;
use App\Models\Pole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ObjectName extends Model
{
    protected $fillable =
        [
            'name',
            'filial_id',
            'object_type_id',
            'pole_id',
        ]
    ;

    public function FilialName(): BelongsTo
    {
        return $this->belongsTo(filial::class, 'filial_id', 'id');
    }

    public function ObjectType(): BelongsTo
    {
        return $this->belongsTo(ObjectType::class, 'object_type_id', 'id');
    }

    public function PoleName(): BelongsTo
    {
        return $this->belongsTo(Pole::class, 'pole_id', 'id');
    }

}
