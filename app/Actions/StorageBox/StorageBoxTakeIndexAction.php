<?php

namespace App\Actions\StorageBox;

use App\Models\Take;


class StorageBoxTakeIndexAction
{
    public function __invoke()
    {
        $take_only = Take::
            select('storage_box_id')
            ->selectRaw('sum(fifty) as fifty')
            ->selectRaw('sum(forty) as forty')
            ->selectRaw('sum(thirty) as thirty')
            ->selectRaw('sum(standard) as standard')
            ->selectRaw('sum(waste) as waste')
            ->selectRaw('sum(land) as land')
            ->groupby('storage_box_id')
            ->get();
        return $take_only;
    }
}
