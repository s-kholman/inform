<?php

namespace App\Http\Controllers;
use App\Jobs\SendSMS;
use App\Mail\RegisteredUser;
use App\Models\Fio;
use App\Models\Agregat;
use App\Models\filial;
use App\Models\import;
use App\Models\Kultura;
use App\Models\PhoneDetail;
use App\Models\PhoneLimit;
use App\Models\posev;
use App\Models\Post;
use App\Models\Registration;
use App\Models\Sms;
use App\Models\Sutki;
use App\Models\svyaz;
use App\Models\Vidposeva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser;
use UniFi_API\Client;

class InfoController extends Controller
{
    private const SMSWIFI_VALIDATOR = [
        'phone' => 'regex:/^\+7\d{10}/|max:12|min:12',
        'smsType' => 'in:WIFI',
        'vaucherDay' => 'integer|between:1,365',
        'smsComment' => 'nullable|string|max:100'];
    //Валидация, сообщения об ошибках
    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов'
    ];
    //Валидация, задаем правила
    private const FILIAL_VALIDATOR = [
        'filial' => 'required|max:20',
    ];

    private const FIO_VALIDATOR = [
        'fio' => 'required|max:20',
    ];


    private const SUTKI_VALIDATOR = [
        'sutki' => 'required|max:20',
    ];

    private const VIDPOSEVA_VALIDATOR = [
        'vidposeva' => 'required|max:20',
    ];

    private const KULTURA_VALIDATOR = [
        'kultura' => 'required|max:20',
        'vidposeva' => 'required'
    ];
    private const KULTURA_ERROR_MESSAGES = [
        'required' => 'Заполните это поле',

        'max' => 'Значение не должно быть длинне :max символов'
    ];

    private const SVYAZ_VALIDATOR = [
        'fio' => 'required',
        'filial' => 'required',
        'vidposeva' => 'required',
        'agregat' =>  'required'
    ];

    private const PRASHOD_VALIDATOR = [
        'pRashod' => 'min:0'
    ];

    public function index_g (){
        if (Auth::check()){
            $user_reg = Auth::user()->registration;
        if ($user_reg){
            return view('index', ['user_reg' => $user_reg] );
        }
        }
        return view('index');
    }


    public function storeFio(Request $request){
        //Валидация данных
        $validated = $request->validate(self::FIO_VALIDATOR,
            self::ERROR_MESSAGES);
        Fio::create(
            [
                'name' => $validated['fio']
            ]);
        return redirect()->route('fio_add');
    }

    public function showAddFioForm() {
        return view('fio_add');
    }
    public function storeSutki(Request $request){
        //Валидация данных
        $validated = $request->validate(self::SUTKI_VALIDATOR,
            self::ERROR_MESSAGES);
        Sutki::create(
            [
                'name' => $validated['sutki']
            ]);
        return redirect()->route('/');
    }

    public function showAddSutkiForm() {
        return view('sutki_add');
    }

    public function store(Request $request){
        //Валидация данных
        $validated = $request->validate(self::KULTURA_VALIDATOR,
            self::KULTURA_ERROR_MESSAGES);
        Kultura::create(
            [
                'name' => $validated['kultura'],
                'vidposeva_id' => $validated['vidposeva']
            ]);
        return redirect()->route('kultura.index');
    }

    public function index() {
        $content = ['vidposevas' => Vidposeva::latest()->get()];
        return view('kultura_add', $content);

    }

    public function showLoginForm() {

        return view('login');
    }

    public function showRegisterForm() {

        return view('register');
    }

    public function showAddVidposevaForm() {

        return view('vidposeva_add');
    }

    public function storeVidposeva(Request $request){
        //Валидация данных
        $validated = $request->validate(self::VIDPOSEVA_VALIDATOR,
            self::ERROR_MESSAGES);
        Vidposeva::create(
            [
                'name' => $validated['vidposeva']
            ]);
        return redirect()->route('/');
    }

    public function showAddSvyazForm() {
        //данные для исключения ФИО из выбора на странице связок уже активных
        $use_fio = svyaz::select('fio_id')->where('active', true)->get();

        $content = ['vidposevas' => Vidposeva::latest()->get(),
            'fios' => fio::whereNotIn('id', $use_fio)->get(),
            'filials' => filial::latest()->get(),
            'agregats'  => agregat::latest()->get(),
        'svyazs' => svyaz::orderby('active', 'DESC')->orderby('id')->get()];

        return view('svyaz_add', $content);
    }

    public function storeSvyaz(Request $request){
        //Валидация данных
        $validated = $request->validate(self::SVYAZ_VALIDATOR,
            self::ERROR_MESSAGES);
        svyaz::create(
            [
                'fio_id' => $validated['fio'],
                'filial_id' => $validated['filial'],
                'vidposeva_id' => $validated['vidposeva'],
                'agregat_id' => $validated['agregat'],
                'date' => now(),
                'active' => true
            ]);
        return redirect()->route('svyaz_add');
    }


    public function showAddPosevForm() {
        //Подготавливаем дынные для динамических форм культура
        foreach (Kultura::all() as $toFormat){
            $kultura [$toFormat->vidposeva_id] [$toFormat->id] = $toFormat->name;
        }
        //Подготавливаем данные для динамических форм - список ФИО
        foreach (svyaz::where('active', true)->get() as $value){
            $all_info [$value->filial_id] [$value->vidposeva_id] [$value->fio_id] = $value->fio->name;
        }

        if (Auth::check()){
            $user_reg = Registration::where('user_id', Auth::user()->id)->first();
            if ($user_reg){
                $content = [
                    'filials' => filial::all(),
                    'vidposevas' => Vidposeva::where('id','<>', 4)->get(),
                    'kultura' => json_encode($kultura, JSON_UNESCAPED_UNICODE),
                    'all_info' => json_encode($all_info, JSON_UNESCAPED_UNICODE),
                    'filial_id' => $user_reg];
                return view('posev_add', $content );
            }
        }


        return view('profile');
    }


    public function storePosev (Request $request){
        //Сохранение информации о работах в БД
        //Делаю дубль массива параметров POST для дальнейшей работы
        $arr = $request->post();

        if (array_key_exists('vidposeva', $arr)){
        $validation_rules = ['filial' => 'required|numeric', 'vidposeva' => 'required|numeric'];
        $validated = Validator::make(['filial' => $arr['filial'], 'vidposeva' => $arr['vidposeva']], $validation_rules); //Валидация данных
        if ($validated->passes()){
        //Удаляю лишнии ключи чтобы нарезать массив
        $filial=$arr['filial'];
        $vidposeva=$arr['vidposeva'];
        unset($arr['filial']);
        unset($arr['vidposeva']);
        unset($arr['_token']);
        //подготавливаем информацию к валидации. Многомерныый массив по 5 элементов
        $arr_chunk = array_chunk($arr, 5, true);
        /*Валидация данных и CRUD:
        1 Проверяем на повтор записи по дата, фио, видпосева, филиал: записываем новую или редактируем старую
        2. Все значения заполненны, но объем стоит 0 (ноль) - удаляем запись по текущим параметрам
        */
        //Начинаем крутить массивы
        foreach ($arr_chunk as $value){
            $id = $value[array_keys($value)[0]]; //У ассоциативного массива узнали первое значение (id ФИО)
            $value['posevGa_'.$id] = str_replace(',','.',$value['posevGa_'.$id]); //Перед проверкой данных заменил запятую на точку от дробной части
            $validation_rules = [ //Фильтр валидации данных
                'posevGa_'.$id => 'required|numeric',
                'id_date_'.$id => 'date',
                'kulturaId_'.$id => 'integer',
                'sutkiId_'.$id => 'integer'
            ];

            $validated = Validator::make($value, $validation_rules); //Валидация данных

            if($validated->passes() AND ($value['posevGa_'.$id] == 0)){ //Passes возвращает истину если валидация пройдена. При нуле удаляем запись
                posev::where('posevDate', $value['dateId_'.$id])
                    ->where('kultura_id', $value['kulturaId_'.$id])
                    ->where('fio_id', $value['idFio_'.$id],)->delete();
            }
            /**
             * Доработка от 11.05.2023
             * Для внесения в одну ячейку нескольких значений
             * переходной этап (сеял овес, стал пшеницу)
             * 'kultura_id' => $value['kulturaId_'.$id], -- перенесена выше
             */
            if($validated->passes() AND ($value['posevGa_'.$id] > 0)){ //При значении больше нуля добавляем или обновляем запись
                //Создаем или редактируем
                $agregat = svyaz::where('fio_id', $id)->where('active', true)->value('agregat_id');
                posev::updateOrCreate([
                    'posevDate' => $value['dateId_'.$id],
                    'fio_id' => $value['idFio_'.$id],
                    'filial_id' => $filial,
                    'vidposeva_id' => $vidposeva,
                    'agregat_id' => $agregat,
                    'kultura_id' => $value['kulturaId_'.$id],
                    'svyaz_id' => svyaz::where('fio_id', $id)->where('active', true)->value('id')],
                    [
                        'sutki_id' => $value['sutkiId_'.$id],

                        'posevGa' => $value['posevGa_'.$id]

                    ]);
            }
        }
        }
        }
        return redirect()->route('otchet', ['key' => $vidposeva]);
        //return redirect()->route('posev_add');

}
public function disableSvyaz(svyaz $svyaz){
       // return view('test', ['request' => $svyaz]);
        svyaz::where('id', $svyaz->id)->update(['active' => false]);
    return redirect()->route('svyaz_add');
}
    public function deleteSvyaz(svyaz $svyaz){
        // return view('test', ['request' => $svyaz]);
        svyaz::where('id', $svyaz->id)->delete();
        return redirect()->route('svyaz_add');
    }



    public function showTestForm()
    {

          return view('test', ['request' => Auth::user()->FilialName->name]);
    }


    private function countArray (array $arr){
        //Количество филиалов указаных в связках на определенный vidposev (читать как вид работы)
        $shablon_filial = svyaz::where('vidposeva_id', '1')->orderby('filial_id')->orderby('agregat_id')->orderby('fio_id')->distinct('filial_id')->get();
        //Количество агрегатов указаных в связках на определенный vidposev (читать как вид работы) и филиал
        $shablon_agregat = svyaz::where('vidposeva_id', '1')->orderby('filial_id')->orderby('agregat_id')->orderby('fio_id')->distinct('filial_id', 'agregat_id')->get();
        //Количество механизаторов указаных в связках на определенный vidposev (читать как вид работы), филиал и агрегат
        $shablon_fio  = svyaz::where('vidposeva_id', '1')->orderby('filial_id')->orderby('agregat_id')->orderby('fio_id')->distinct('filial_id', 'agregat_id', 'fio_id')->get();
        //Весь посев
        $shablon_arr = posev::where('vidposeva_id', '1')->distinct('filial_id', 'agregat_id', 'fio_id')->get();
        //Дни когда был посев (работа)
        $arrDate = posev::where('vidposeva_id', '1')->orderby('posevDate')->distinct('posevDate')->get();
        //Создаем шаблон все механизаторы по филиалам и агрегатам
        foreach ($shablon_fio as $value){
            $shablon [] = ['0' => $value['filial_id'], '1' => $value['agregat_id'], '2' => $value['fio_id']];
        }

        return  (['arr' => $arr, 'shablon' => $shablon, 'arrDate' => $arrDate,
            'shablon_arr' => $shablon_arr, 'shablon_filial' => $shablon_filial, 'shablon_agregat' => $shablon_agregat, 'shablon_fio' => $shablon_fio]);

}
    public function otchet(Request $request){

        if(posev::where('vidposeva_id', $request->key)->orderby('posevDate')->count()){

            $arrPosev = posev::where('vidposeva_id', $request->key)->orderby('posevDate')->get();
            //Формируем матрицу для шаблона
            foreach ($arrPosev as $value) {
                //$sortPosev [$value->posevDate] [$value->filial_id] [$value->agregat_id] [$value->fio_id] = json_encode(['kultura_id' => $value->kultura_id, 'posevGa' => $value->posevGa]);
                /**
                 * Доработка от 11.05.2023
                 * Для внесения в одну ячейку нескольких значений
                 * переходной этап (сеял овес, стал пшеницу)
                 */
                $sortPosev [$value->posevDate] [$value->filial_id] [$value->agregat_id] [$value->fio_id] =
                json_encode(posev::select('kultura_id', 'posevGa')
                    ->where('vidposeva_id', $request->key)
                    ->where('posevDate', $value->posevDate)
                    ->where('filial_id', $value->filial_id)
                    ->where('agregat_id', $value->agregat_id)
                    ->where('fio_id', $value->fio_id)
                    ->orderby('posevDate')->get());
            }

            //Количество филиалов указаных в связках на определенный vidposev (читать как вид работы)
            $shablon_filial = svyaz::where('vidposeva_id', $request->key)->orderby('filial_id')->orderby('agregat_id')->orderby('fio_id')->distinct('filial_id')->get();
            //Количество агрегатов указаных в связках на определенный vidposev (читать как вид работы) и филиал
            $shablon_agregat = svyaz::where('vidposeva_id', $request->key)->orderby('filial_id')->orderby('agregat_id')->orderby('fio_id')->distinct('filial_id', 'agregat_id')->get();
            //Количество механизаторов указаных в связках на определенный vidposev (читать как вид работы), филиал и агрегат
            $shablon_fio  = svyaz::where('vidposeva_id', $request->key)->orderby('filial_id')->orderby('agregat_id')->orderby('fio_id')->distinct('filial_id', 'agregat_id', 'fio_id')->get();
            //Весь посев
            $shablon_arr = posev::where('vidposeva_id', $request->key)->distinct('filial_id', 'agregat_id', 'fio_id')->get(); //Добавил kultura_id
            //Дни когда был посев (работа)
            $arrDate = posev::where('vidposeva_id', $request->key)->orderby('posevDate')->distinct('posevDate')->get();
            //Создаем шаблон все механизаторы по филиалам и агрегатам
            foreach ($shablon_fio as $value){
               $shablon [] = ['0' => $value['filial_id'], '1' => $value['agregat_id'], '2' => $value['fio_id']];

            }

            return  view('otchet', ['arr' => $sortPosev, 'shablon' => $shablon, 'arrDate' => $arrDate, 'key' => $request->key,
                'shablon_arr' => $shablon_arr, 'shablon_filial' => $shablon_filial, 'shablon_agregat' => $shablon_agregat, 'shablon_fio' => $shablon_fio]);
        } else {
            return view('404');
        }


       // return view('otchet', self::countArray($sortPosev));
    }

    public function showAddPostForm(){
       return view('post_add');

    }

    public function storePost(Request $request){
        $post = new Post();
        $post->name = $request->post;
        $post->save();
        return redirect(route('post_add'));
    }

    public function translit($str) {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
        return str_replace($rus, $lat, $str);
    }

public function filial (filial $filial){
        //return var_dump($filial);//$filial->name;
    return view('test', ['request' => $filial]);
}

}

