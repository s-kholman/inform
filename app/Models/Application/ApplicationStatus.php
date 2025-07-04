<?php

namespace App\Models\Application;

use App\Http\Controllers\Application\ApplicationRun;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'name',
            'status_code',
        ];


}
