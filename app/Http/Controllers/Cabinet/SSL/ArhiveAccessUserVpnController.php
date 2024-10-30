<?php

namespace App\Http\Controllers\cabinet\ssl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ZipArchive;

class ArhiveAccessUserVpnController extends Controller
{
    use TempDir;

    private array $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
    public function __invoke($fileName, $exportFileType)
    {
        $zip = new ZipArchive;
        if ($zip->open($this->pathTemp() .$fileName.'.zip', ZipArchive::CREATE) === TRUE) {
            if (!$this->user['settings']->scriptW10){
                $zip->addFile($this->pathTemp(). $fileName.'.p12', 'ssl_'.$fileName.'.p12');
            }
                $zip->addFile($this->pathTemp() . $fileName, 'script_'.$fileName.$exportFileType);
            }
            $zip->close();
        }
}
