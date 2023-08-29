<?php

namespace App\Actions\StorageBox;

use App\Models\Gues;
use App\Models\Take;

class StorageBoxReportIndex
{
    public function __invoke($storagebox)
    {
        $take = Take::where('storage_box_id', $storagebox->id)->get();
        $gues = Gues::where('storage_box_id', $storagebox->id)->get();
        $all = collect($take)->merge(collect($gues))->sortByDesc('created_at')->sortByDesc('date');
        return ['all' => $all, 'storagebox' => $storagebox];
    }
}
