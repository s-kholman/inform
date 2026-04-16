<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class filial extends Model
{
    protected $fillable = ['name'];

    public function Pole(): HasMany
    {
        return $this->hasMany(Pole::class);
    }

    public function Registration(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

}
