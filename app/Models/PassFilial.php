<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassFilial extends Model
{
    use HasFactory;
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'number_car',
            'last_name',
            'user_id',
            'filial_id',
            'printed',
            'date',
            'comments'
        ];

    public function Registration()
    {
        return $this->belongsTo(Registration::class, 'user_id', 'user_id');
    }
}
