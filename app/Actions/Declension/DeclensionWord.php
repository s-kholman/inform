<?php

namespace App\Actions\Declension;

class DeclensionWord
{
    /*
     * $count - число которое склоняем
     * $pronoun - Числительное «один» склоняется как местоимение - один "День"
     * $nominativeCase - именительный падеж — два, три, четыре - два "Дня"
     * $nouns - существительные 3-го склонения - пять "Дней"
     * */
    public function __invoke($count, $pronoun, $nominativeCase, $nouns) : string
    {

        if ($count >= 11 and $count <=14){

            return $count. ' ' .$nouns;

        }else{

            $i = $count % 100;

            $i = $i % 10;

            if ($i == 1) {

                return $count . ' ' . $pronoun;

            } elseif ($i >= 2 and $i <= 4) {

                return $count . ' ' . $nominativeCase;

            } else {

                return $count. ' ' . $nouns;

            }
        }
    }
}
