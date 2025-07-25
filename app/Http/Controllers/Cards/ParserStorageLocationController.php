<?php

namespace App\Http\Controllers\Cards;

use App\Http\Controllers\Controller;

class ParserStorageLocationController extends Controller
{

    public function __invoke():array
    {
        $storageLocation = [];

        if (file_exists(storage_path() .'/app/public/card/storageLocation.xml'))
        {
            $dom = new \XMLReader();
            $dom -> open(storage_path() .'/app/public/card/storageLocation.xml');

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
        }

        return $storageLocation;
    }
}
