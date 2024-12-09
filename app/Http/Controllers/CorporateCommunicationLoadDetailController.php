<?php

namespace App\Http\Controllers;

use App\Models\PhoneDetail;
use App\Models\PhoneLimit;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class CorporateCommunicationLoadDetailController extends Controller
{
    public function index()
    {
        return view('corporateCommunication/load');
    }

    public function render(Request $request)
    {
        //$i=0;

        if ($request->hasFile('pdf')) {
            $parser = new Parser();
            $pdf = $parser->parseFile($request->file('pdf'))->getText();
            //preg_match("/(?<=Счет за\s).*\d/", $pdf, $mount);
            preg_match("/(\d{2})\.(\d{2})\.(\d{4})/", $pdf, $date);
            //Проверка файла на корректность (Если регулярное выражение не вернуло строку, значит что-то не так)


            if (array_key_exists(0, $date)){
                $mount = date('n', strtotime($date[0]));
                $year = date('Y', strtotime($date[0]));

                preg_match_all("/(?<=Абонент\s)\d{11}/", $pdf, $arrPhone); //Получаем массив телефонов
                preg_match_all("/(?<=Итого начисления)(.+?)р/", $pdf, $arrSumma); //Получаем начисления по телефонам
                //получаем связку телефон = сумма начисления
                foreach ($arrSumma[1] as $value){
                    //Приводим сумму к значению float, заменяя запятую на точку
                    $arrPhoneToSumma [$arrPhone[0][$i++]] = str_replace(',', '.',filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND));
                }
                //Создаем готовый массив для показа и сохранения в БД JSON-ом
                $limit = PhoneLimit::query()->where('active', true)->orderby('fio')->get();
                foreach ($limit as $value){
                    if(!empty($arrPhoneToSumma) && array_key_exists($value->phone,$arrPhoneToSumma)){
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
                    } else{
                        return redirect()->route('communication.report.show');
                    }
                }
                //Сохраняем или обновляем запись по ключу месяц-год
                PhoneDetail::updateOrCreate([
                    'DetailDate' => '1-'.$mount.'-'.$year],
                    [
                        'DetailJSON' => json_encode($arrPhoneToSumma),
                        'DetailViewJSON' => json_encode($DetailViewJSON)]);
            } else {
                $temp = 'Файл не прошел валидацию';
            }
        } else {
            $temp = 'Файл не корректен';
        }

        return redirect()->route('communication.report.show');
    }
}
