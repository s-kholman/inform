<?php

namespace App\Actions\StorageBox;

use App\Models\StorageBox;
use App\Models\StorageName;


class StorageBoxIndexAction
{
    public function __invoke()
    {
        $all = StorageBox::with('storageName')->get();
        $storage = $all->
        sortBy('storageName.name');
        return $storage;
    }
}
