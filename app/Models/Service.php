<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function filial()
    {
        return $this->belongsTo(filial::class);
    }

    public function ServiceName()
    {
        return $this->belongsTo(ServiceName::class, 'service_names_id');
    }
}
