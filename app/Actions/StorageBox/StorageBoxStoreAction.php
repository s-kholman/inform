<?php

namespace App\Actions\StorageBox;

use App\Models\StorageBox;

class StorageBoxStoreAction
{
    public function __invoke($request)
    {
        StorageBox::create([
            'storage_name_id' => $request['storage_name'],
            'field' => $request['field'],
            'kultura_id' => $request['selectFirst'],
            'nomenklature_id' => $request['selectSecond'],
            'reproduktion_id' => $request['selectThird'],
            'type' => $request['type'],
            'volume' => $request['volume']
        ]);

    }

}
