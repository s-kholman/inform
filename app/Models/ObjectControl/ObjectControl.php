<?php

namespace App\Models\ObjectControl;

use App\Models\filial;
use App\Models\Pole;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ObjectControl extends Model
{
    protected $fillable =
        [
            'object_name_id',
            'filial_id',
            'object_control_point_id',
            'object_control_importance_id',
            'user_id',
            'pole_id',
            'messages',
            'date',
        ];

    public function objectName(): BelongsTo
    {
        return $this->belongsTo(ObjectName::class);
    }

    public function filial(): BelongsTo
    {
        return $this->belongsTo(filial::class);
    }

    public function objectControlPoint(): BelongsTo
    {
        return $this->belongsTo(ObjectControlPoint::class);
    }

    public function objectControlImportance(): BelongsTo
    {
        return $this->belongsTo(ObjectControlImportance::class);
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Pole(): BelongsTo
    {
        return $this->belongsTo(Pole::class);
    }

}
