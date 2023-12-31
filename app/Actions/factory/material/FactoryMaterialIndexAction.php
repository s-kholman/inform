<?php

namespace App\Actions\factory\material;

use App\Models\FactoryMaterial;

class FactoryMaterialIndexAction
{
    public function __invoke()
    {
        $materials = FactoryMaterial::with('gues')->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get();
        return $materials;
    }

}
