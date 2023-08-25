<?php

namespace App\Actions\sowing\svyaz;

use Illuminate\Support\Facades\DB;

class SvyazCreateAction
{
    public function __invoke()
    {
        $fio = DB::table('fios')
            ->select('fios.id', 'fios.name')
            ->leftJoin('svyazs', 'fios.id', '=', 'svyazs.fio_id')
            ->whereNull('fio_id')
            ->orderBy('fios.name')
            ->get();
        return $fio;
    }
}
