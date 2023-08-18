<?php

namespace App\Actions\StorageBox;

use App\Models\StorageBox;


class StorageBoxIndexAction
{
    public function __invoke()
    {
        $storage = StorageBox::all();
        return $storage;
    }
}
