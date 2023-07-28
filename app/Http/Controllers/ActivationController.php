<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Sms;
use App\Models\User;
use Illuminate\Http\Request;

class ActivationController extends Controller
{
    public function activation(){
        $users = User::all();

        return view('user_view', ['users' => $users]);
    }

    public function userView(Request $request){


        $active = Registration::where('user_id',$request->id)->first();

        return view('user_edit', ['user' => $active]);
    }

    public function userActivation(Request $request){
        $activation = Registration::find($request->id);
        $activation->activation = true;
        $activation->infoFull = true;
        Sms::create([
            'smsText' => 'Администратор активировал Ваш профиль на сайте inform.krimm.ru',
            'phone' => $activation->phone ,
            'smsType' => 1,
            'smsActive' => true]);
        $activation->save();

        return redirect()->route('activation.show');

    }

    public function userEdit(Request $request){
        $edit = Registration::find($request->id);
        $edit->infoFull = false;
        $edit->activation = false;

        Sms::create([
            'smsText' => 'Профиль на сайте inform.krimm.ru не прошел проверку и отправлен на редактирование',
            'phone' => $edit->phone ,
            'smsType' => 1,
            'smsActive' => true]);
        $edit->save();
        return redirect()->route('activation.show');

    }
}
