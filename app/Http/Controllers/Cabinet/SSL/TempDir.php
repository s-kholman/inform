<?php

namespace App\Http\Controllers\Cabinet\SSL;

trait TempDir
{

    public function pathTemp():string
    {
        $path_temp = storage_path() . '/app/temp/';

        if (!file_exists($path_temp)) {
            mkdir($path_temp, 0777, true);
        }
        return $path_temp;
    }
}
