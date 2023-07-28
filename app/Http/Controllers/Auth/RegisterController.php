<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendSMS;
use App\Models\Sms;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    //protected $redirectTo = RouteServiceProvider::HOME;
    //После регистрации перенаправление на заполнения профиля
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        /*Убранно валидации имя пользователя
        'name' => ['required', 'string', 'max:255'],*/
        return Validator::make($data, [

            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        /*Ставим в очередь отправку SMS*/
        //SendSMS::dispatch('Register user - '.$data['email']. ' - '. now());

        /**
         * Сделанна новая отправка СМС через мобильное приложение
         */
        Sms::create([
            'smsText' => 'Регистрация пользователя ' . $data['email'],
            'phone' => '+79026223673',
            'smsType' => 1,
            'smsActive' => true
        ]);


        /*Логин дублируется E-Mail-ом и из формы убрано поле логин
        name' => $data['name'],*/

        return User::create([
            'name' => $data['email'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
