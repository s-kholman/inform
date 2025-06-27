<?php

namespace App\Http\Controllers;

use App\Events\UserDestroyEvent;
use App\Models\Registration;
use App\Models\Sms;
use App\Models\User;
use Illuminate\Http\Request;


class ActivationController extends Controller
{
    public function index()
    {
        $users = User::query()->orderByDesc('created_at')->get();
        return view('profile.activation.index', ['users' => $users]);
    }


    public function userActivation(Registration $registration)
    {
        $registration->activation = true;
        $registration->infoFull = true;
        $registration->save();

        Sms::query()
            ->create([
                'smsText' => 'Администратор активировал Ваш профиль на сайте '. env('APP_URL'),
                'phone' => $registration->phone ,
                'smsType' => 1,
                'smsActive' => true,
            ]);

        return redirect()->route('activation.index');
    }

    public function userEdit(Registration $registration)
    {
        $registration->infoFull = false;
        $registration->activation = false;
        $registration->save();

        Sms::query()
            ->create([
                'smsText' => 'Профиль на сайте '.env('APP_URL').' не прошел проверку, необходимо заполнить корректно',
                'phone' => $registration->phone ,
                'smsType' => 1,
                'smsActive' => true
            ]);

        return redirect()->route('activation.index');
    }

    public function destroy(Registration $registration)
    {
        UserDestroyEvent::dispatch(User::query()->find($registration->user_id));

        $registration->User->delete();

        return response()->json(['status'=>true,"redirect_url"=>url('activation')]);
    }

    public function forceDelete(User $user)
    {
        $user->forceDelete();

        return redirect()->route('activation.index');
    }
}
