<?php

namespace App\Http\Controllers\Cards;

use App\Http\Controllers\Controller;

class ParserStorageLocationController extends Controller
{

    public function __invoke($pathFile = '/app/public/card/storageLocation.xml'):array
    {
        $storageLocation = [];
        $ref = null;
        $dom = new \XMLReader();
        if (file_exists(storage_path() .$pathFile)){
            $dom -> open(storage_path() .$pathFile);
        } elseif ($pathFile != '/app/public/card/storageLocation.xml'){
            $dom -> xml($pathFile);
        } else{

            return $storageLocation;
        }
            while ($dom->read()){
                if ($dom->nodeType == \XMLReader::ELEMENT && $dom->localName == 'CatalogObject.Склады'){

                    while ($dom->read()){
                        if ($dom->localName == 'Description') {
                            $dom->read();
                            if ($dom->nodeType == \XMLReader::TEXT) {
                                $description = $dom->value;
                                break;
                            }
                        }
                        if ($dom->localName == 'Ref') {
                            $dom->read();
                            if ($dom->nodeType == \XMLReader::TEXT) {
                                $ref = $dom->value;
                            }
                        }
                    }
                    if ($ref !== null){
                        $storageLocation [$ref] = $description ;
                    }
                }
            }
        return $storageLocation;
    }
}
