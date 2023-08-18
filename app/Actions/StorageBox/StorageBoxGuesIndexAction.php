<?php

namespace App\Actions\StorageBox;

use App\Models\Gues;
use App\Models\StorageBox;


class StorageBoxGuesIndexAction
{
    public function __invoke()
    {
        $gues_all = Gues::all();
        $gues_only = $gues_all->
        sortByDesc('date')->
        sortByDesc('created_at')->
        unique('storage_box_id');
        return $gues_only;
    }
}
