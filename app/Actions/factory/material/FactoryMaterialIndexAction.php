<?php

namespace App\Actions\factory\material;

use App\Models\FactoryMaterial;

class FactoryMaterialIndexAction
{
    public function __invoke()
    {
        $materials = FactoryMaterial::all();
        return $materials;
    }

}
