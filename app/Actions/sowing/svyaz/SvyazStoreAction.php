<?php

namespace App\Actions\sowing\svyaz;


use App\Models\svyaz;

class SvyazStoreAction
{
    public function __invoke($request)
    {
        svyaz::create(
            [
                'fio_id' => $request['fio'],
                'filial_id' => $request['filial'],
                'vidposeva_id' => $request['vidposeva'],
                'agregat_id' => $request['agregat'],
                'date' => now(),
                'active' => true
            ]);

    }

}
