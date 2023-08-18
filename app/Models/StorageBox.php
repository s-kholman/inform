<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StorageBox extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['storage_name_id','field','kultura_id','nomenklature_id','reproduktion_id','type','volume'];

    public function storageName()
    {
       return $this->belongsTo(StorageName::class);
    }

    public function nomenklature()
    {
        return $this->belongsTo( Nomenklature::class);
    }

    public function reproduktion()
    {
        return $this->belongsTo( Reproduktion::class);
    }

}
