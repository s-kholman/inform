<?php

namespace App\Actions\StorageBox;

use App\Models\Take;


class StorageBoxTakeSumAction
{
    public function __invoke($storageBox)
    {
        $take_only = Take::
            where('storage_box_id', $storageBox->id)
            ->selectRaw('sum(fifty) as fifty')
            ->selectRaw('sum(forty) as forty')
            ->selectRaw('sum(thirty) as thirty')
            ->selectRaw('sum(standard) as standard')
            ->selectRaw('sum(waste) as waste')
            ->selectRaw('sum(land) as land')
            ->first();

        return collect($take_only)->sum();


    }
}
