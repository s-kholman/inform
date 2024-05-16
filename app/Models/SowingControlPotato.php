<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SowingControlPotato extends Model
{
    use HasFactory;
    protected $fillable =
        [
            'date',
            'type_field_work_id',
            'sowing_last_name_id',
            'pole_id',
            'filial_id',
            'harvest_year_id',
            'point_control',
            'result_control_agronomist',
            'result_control_director',
            'result_control_deputy_director',
            'comment',
        ];

    public function TypeFieldWork():BelongsTo
    {
        return $this->belongsTo(TypeFieldWork::class);
    }

    public function SowingLastName():BelongsTo
    {
        return $this->belongsTo(SowingLastName::class);
    }

    public function Pole():BelongsTo
    {
        return $this->belongsTo(Pole::class);
    }

    public function Filial():BelongsTo
    {
        return $this->belongsTo(filial::class);
    }

    public function HarvestYear():BelongsTo
    {
        return $this->belongsTo(HarvestYear::class);
    }
}
