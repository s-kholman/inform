<?php

namespace App\Http\Controllers\Cards;

use App\Http\Controllers\Controller;

class ParseInformationContragentController extends Controller
{
    private $storageLocation;
    private $messages;

    public function __invoke($path, CardMessagesController $messages)
    {
        $this->messages = $messages;
        $parserStorageLocation = new ParserStorageLocationController();
        $this->storageLocation = $parserStorageLocation();

        $reverse = [];
        $reverseStatus = false;
        $parse_csv = [];
        $countRow = 0;

        $handle = fopen($path, 'r');

        fgetcsv($handle, 1000, ';');

        while (($data = fgetcsv($handle, 1000, ';')) !== false){

            if (count($data) == 17){

                if ($reverseStatus && ($data[2] == $reverse[2])){
                    $data[7] = $data[7] + $reverse[7];
                    $data[16] = $data[16] + $reverse[16];
                    $data[14] = $data[14] + $reverse[14];
                    $reverseStatus = false;
                    $this->messages->addMessage('Reverse', $data[2], $reverse[0] . ' уменьшен объем ' . $reverse[7] . ' и сумма на '  . $reverse[16]);
                } elseif ($reverseStatus){
                    $this->messages->addMessage('ReverseFailed',$data[2],  ' сторнирование не удалось');
                    $reverseStatus = false;
                }

                if($data[7] > 0){
                    $countRow++;
                    $parse_csv[$data[2]][] =
                        [
                            'value' => $data[7],
                            'sklad' => substr($data[2],14,4),
                            'sklad_id' => $this->skladID($data),
                            'price' => $data[11],
                            'summa' => $data[16],
                            'nds' => $data[14],
                            'type' => $data[5],
                            'ndsText' => $this->ndsText($data),
                        ];
                } else{
                    $reverse = $data;
                    $reverseStatus = true;
                }
            }
        }
        $this->messages->addMessage('countRow', 'count', $countRow);
        fclose($handle);
        return $parse_csv;
    }


    private function ndsText($data):string
    {
        if (round($data[13]) == 20){
            return 'НДС20';
        } else {
            $this->messages->addMessage('NDSError',$data[2], $data[0]);
            return 'НДС0';
        }
    }

    private function skladID($data)
    {
        $sklad_id = array_search(substr($data[2],14,4), $this->storageLocation);

        if ($sklad_id){
            return $sklad_id;
        } else {
            $this->messages->addMessage('skladIDEmpty',$data[2], '. Добавить склад: ' . substr($data[2],14,4));
            return '00000000-0000-0000-0000-000000000000';
        }
    }
}
