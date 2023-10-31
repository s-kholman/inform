<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DeviceName extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'brend_id'
    ];

    //Создаю как стандарт в зависимые справочники для получения доступа в blade шаблоне
    public function Brend() : BelongsTo
    {
        return $this->belongsTo(Brend::class);
    }

    public function miboid () : BelongsToMany
    {
        return $this->belongsToMany(MibOid::class);
    }


}
