<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SzrResource;
use App\Models\Szr;

class SzrController extends Controller
{
    public function get($id) {
        return SzrResource::collection(
            Szr::query()
                ->where('szr_classes_id', $id)
                ->orderBy('name')
                ->get()
        );
    }
}
