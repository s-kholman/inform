<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

use App\Actions\TempDir\TempDir;
use App\Http\Controllers\Controller;
use ZipArchive;

class Archive extends Controller
{
    use TempDir;

    /**
     * @throws \Exception
     */
    public function __invoke(array $files, $fileZipName, IkeReport $report)
    {
        try {
            $zip = new ZipArchive;

            if ($zip->open($this->pathGet() . $fileZipName . '.zip', ZipArchive::CREATE) === TRUE) {

                foreach ($files as $file) {
                    $zip->addFile($this->pathGet() . $file, $file);
                }
            }
            $zip->close();
            $report->set('archive', 'Архивация прошла успешно');
        } catch (\Exception $exception) {
            throw new \Exception('Ошибка архивации файлов');
        }
    }
}
