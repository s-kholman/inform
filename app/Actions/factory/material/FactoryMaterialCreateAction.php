<?php

namespace App\Actions\factory\material;

use App\Models\filial;
use App\Models\Nomenklature;

class FactoryMaterialCreateAction
{
    public function __invoke()
    {
        $filials = filial::all();
        $nomenklatures = Nomenklature::all();
        return [$filials, $nomenklatures];
    }
}
