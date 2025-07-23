<?php

namespace App\Http\Controllers;

use App\Actions\Acronym\AcronymFullNameUser;
use App\Http\Controllers\TermoPrinter\TermoPrinterController;
use App\Http\Requests\PassFilialRequest;
use App\Models\PassFilial;
use App\Models\TermPrinterSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PassFilialController extends Controller
{
    public function index(Request $request)
    {

        $passToDay = PassFilial::query()->with('Registration')->whereDate('date', now())->get();

        $fullName = new  AcronymFullNameUser();

        return view('passFilial/index', ['passToDay' => $passToDay, 'fullName' => $fullName, 'messages' => $request->query('messages')]);
    }
    public function create()
    {
        $filials = TermPrinterSettings::query()->get();
       return view('passFilial/create', ['filials' => $filials]);
    }

    public function store(PassFilialRequest $filialRequest)
    {

        $passFilial = PassFilial::query()
            ->create([
                'number_car' => $filialRequest->numberCar,
                'last_name' => $filialRequest->lastName,
                'user_id' => Auth::user()->id,
                'filial_id' => $filialRequest->filial,
                'printed' => true,
                'date' => $filialRequest->date,
                'comments' => $filialRequest->comment,
            ]);



            $printed = new TermoPrinterController();

            $status = $printed->print($passFilial);


        return redirect()->route('pass.filial.index', $status);


    }

    public function check(Request $request)
    {
        $validation = Validator::make($request->query(), ['key' => 'required|uuid:4']);
        $message = '';
        $color = 'black';
        if ($validation->passes()){
            $validated = $validation->validated();

            $check = PassFilial::query()->find($validated['key']);
            if (!empty($check)){
                if ($check->date == Carbon::now()->format('Y-m-d')){
                    $message = 'Пропуск действителен';
                    $color = 'green';
                } else {
                    $message = 'Пропуск просрочен или не наступила дата';
                    $color = 'blue';
                }
            }else {
                $message = 'Данные о пропуске не найдены';
                $color = 'red';
            }
        } else {
            $message = 'Ошибка запроса';
            $color = 'red';
        }

        return view('passFilial/check', ['message' => $message, 'color' => $color]);
    }


}
