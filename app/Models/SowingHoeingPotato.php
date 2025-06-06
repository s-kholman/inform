<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SowingHoeingPotato extends Pivot
{
    protected $fillable = [
        'date',
        'type_field_work_id',
        'sowing_last_name_id',
        'pole_id',
        'filial_id',
        'volume',
        'shift_id',
        'harvest_year_id',
        'hoeing_result_agronomist',
        'hoeing_result_director',
        'hoeing_result_deputy_director',
        'comment',
        'hoeing_result_agronomist_point_1',
        'hoeing_result_agronomist_point_2',
        'hoeing_result_agronomist_point_3',
        'hoeing_result_director_point_1',
        'hoeing_result_director_point_2',
        'hoeing_result_director_point_3',
        'hoeing_result_deputy_director_point_1',
        'hoeing_result_deputy_director_point_2',
        'hoeing_result_deputy_director_point_3',
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

    public function Shift():BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

}
