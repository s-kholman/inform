<?php

namespace App\Actions\TempDir;

trait TempDir
{

    public function pathGet():string
    {
        $path_temp = storage_path() . '/app/temp/';

        if (!file_exists($path_temp)) {
            mkdir($path_temp, 0777, true);
        }
        return $path_temp;
    }
}
