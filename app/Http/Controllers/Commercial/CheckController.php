<?php

namespace App\Http\Controllers\Commercial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function index()
    {
        return view('commercial.check');
    }

    public function check(Request $request)
    {
        $partnerOne = explode(PHP_EOL, $request['PartnerOne']);
        $partnerTwo = explode(PHP_EOL, $request['PartnerTwo']);

        foreach ($partnerTwo as $item){
            if ($item <> ''){
                $inParser = $this->parser($item);
                $arrParserPartnerTwo [$inParser[0]] = $inParser[1];
            }

        }

        foreach ($partnerOne as $value){
            if ($value <> '') {
                $inParser = $this->parser($value);
                $arrParserPartnerOne [$inParser[0]] = $inParser[1];
            }
        }

        if (!empty($arrParserPartnerOne) && !empty($arrParserPartnerTwo)){
            return view('commercial.check', [
                'arrPartnerTwo' => array_diff_assoc($arrParserPartnerTwo, $arrParserPartnerOne),
                'arrPartnerOne' => array_diff_assoc($arrParserPartnerOne, $arrParserPartnerTwo),
                'defaultOne' => $request['PartnerOne'],
                'defaultTwo' => $request['PartnerTwo'],
            ]);
        } else{
            return view('commercial.check');
        }
    }

    private function parser(string $value): array
    {
        $toString =  str_replace([',', "\u{00a0}", "\t"],['.', '', ' '], $value);
        $ltrim = ltrim($toString, 0);
        $number = substr($ltrim, 0, strpos($ltrim, ' '));
        $summa = abs((float)str_replace(' ', '',substr($ltrim, strpos($ltrim, ' ')+1)));
        return [$number, $summa];
    }
}
