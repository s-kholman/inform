<?php

namespace App\Http\Controllers;

use App\Models\PhoneDetail;
use App\Models\PhoneLimit;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class LimitsController extends Controller



{
    public function showLimit (PhoneDetail $phoneDetail){

        if ($phoneDetail->DetailDate == null){
            $phoneDetail = PhoneDetail::latest('DetailDate')->first();
        }
        return view('limit_view', [
            'itogTable' => json_decode($phoneDetail->DetailViewJSON),
            'DetailDate' => $phoneDetail->DetailDate
        ]);
    }


    public function showLimitForm (){
        //Текущие лимиты
        $limit = PhoneLimit::orderby('fio')->get();
        //Итоговая таблица
        $itogTable = PhoneDetail::orderby('DetailDate', 'DESC')->take(1)->value('DetailViewJSON');
        //$itogTable = PhoneDetail::where('id', 5)->value('DetailViewJSON');
        $toItog = json_decode($itogTable);

        return view('limit_add', ['limit' => $limit, 'itogTable' => $toItog]);
    }

public function storeLimit (Request $request){

PhoneLimit::updateOrCreate([
    'phone' => $request->phone,
], [
        'fio' => $request->fio,
        'limit' => $request->limit,
        'active' => true
    ]
);
    return redirect()->route('limit_add');
}

public function parserLimit (Request $request){
$mount_name_arr = [
    'ЯНВАРЬ' => '1',
    'ФЕВРАЛЬ' => '2',
    'МАРТ' => '3',
    'АПРЕЛЬ' => '4',
    'МАЙ' => '5',
    'ИЮНЬ' => '6',
    'ИЮЛЬ' => '7',
    'АВГУСТ' => '8',
    'СЕНТЯБРЬ' => '9',
    'ОКТЯБРЬ' => '10',
    'НОЯБРЬ' => '11',
    'ДЕКАБРЬ' => '12'
];
$i=0;

    if ($request->hasFile('pdf')) {
        $parser = new Parser();
        $pdf = $parser->parseFile($request->file('pdf'))->getText();
        preg_match("/(?<=Счет за\s).*\d/", $pdf, $mount);
       //Проверка файла на корректность (Если регулярное выражение на вернуло строку, значит чтото не так)
        if (!empty($mount)){
            $mount_name =  mb_strtoupper(substr($mount[0],0, strpos($mount[0], ' '))); //Получаем название месяца из детализации
            $yaer = substr($mount[0],strpos($mount[0], ' ')+1);         //Поучаем год из детализации
            preg_match_all("/(?<=Абонент\s)\d{11}/", $pdf, $arrPhone); //Получаем массив телефонов
            preg_match_all("/(?<=Итого начисления)(.+?)р/", $pdf, $arrSumma); //Получаем начисления по телефонам
            //получааем связку телефон = сумма начисления
            foreach ($arrSumma[1] as $value){
                //Приводим сумму к значению float, заменяя запятую на точку
                $arrPhoneToSumma [$arrPhone[0][$i++]] = str_replace(',', '.',filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND));
            }
            //Создаем готовый массив для показа и сохраниния в БД JSON-ом
            $limit = PhoneLimit::where('active', true)->orderby('fio')->get();
            foreach ($limit as $value){
                if(array_key_exists($value->phone,$arrPhoneToSumma)){
                    if ($value->limit-$arrPhoneToSumma[$value->phone] < 0){
                        $pRashod = $value->limit-$arrPhoneToSumma[$value->phone];
                    }
                    else{
                        $pRashod = '';
                    }
                    $DetailViewJSON [] =json_encode([
                        'fio' => $value->fio,
                        'phone' => $value->phone,
                        'limit' => $value->limit,
                        'rashod' => $arrPhoneToSumma[$value->phone],
                        'pRashod' => $pRashod
                    ]);
                }
            }
            //Сохраняем или обновляем запись по ключу месяц-год
            PhoneDetail::updateOrCreate([
                'DetailDate' => '1-'.$mount_name_arr[$mount_name].'-'.$yaer],
                [
                    'DetailJSON' => json_encode($arrPhoneToSumma),
                    'DetailViewJSON' => json_encode($DetailViewJSON)]);
        } else {
            $temp = 'Файл не прошел валидацию';
        }
    } else {
        $temp = 'Файл не корректен';
    }

    return redirect()->route('limit_add');
}
 public function limitEdit (Request $request){
        $limit = PhoneLimit::where('id', $request['limitID'])->get();
        return view('/limit_edit', ['limit' => $limit]);
 }

 public function limitdestroy (Request $request) {
        PhoneLimit::where('id', $request['limitID'])->delete();
        return redirect()->route('limit_add');
 }

}
