<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Sms;
use App\Models\User;
use Illuminate\Http\Request;


class ActivationController extends Controller
{
    public function activation(){
        $users = User::query()->orderByDesc('created_at')->get();
        return view('user_view', ['users' => $users]);
    }

    public function userView(Request $request){


        $active = Registration::where('user_id',$request->id)->first();

        return view('user_edit', ['user' => $active]);
    }

   // public function userActivation(Request $request){
    public function userActivation(Registration $registration){

        $registration->activation = true;
        $registration->infoFull = true;
        $registration->save();

        Sms::create([
            'smsText' => 'Администратор активировал Ваш профиль на сайте '. env('APP_URL'),
            'phone' => $registration->phone ,
            'smsType' => 1,
            'smsActive' => true]);

        return redirect()->route('activation.show');

    }

    public function userEdit(Registration $registration){

        $registration->infoFull = false;
        $registration->activation = false;
        $registration->save();

        Sms::create([
            'smsText' => 'Профиль на сайте '.env('APP_URL').' не прошел проверку, необходимо заполнить корректно',
            'phone' => $registration->phone ,
            'smsType' => 1,
            'smsActive' => true]);

        return redirect()->route('activation.show');

    }

    public function destroy(Registration $registration)
    {
        $registration->delete();

        User::query()->find($registration->user_id)->delete();

        return redirect()->route('activation.show');
    }

    public function forceDelete(User $user)
    {
        $user->forceDelete();

        return redirect()->route('activation.show');
    }
}
