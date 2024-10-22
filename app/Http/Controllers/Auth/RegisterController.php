<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendSMS;
use App\Models\Sms;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


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
        /*
         * Правим проверку на валидность адресов, не различал регистр
         * Теперь все адреса приводим к нижнему регистру и отправляем на валидацию
        */
        $data['email'] = Str::lower($data['email']);
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],
        [
            'unique' => 'Email уже зарегистрирован'
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
        /**
         * Сделана новая отправка СМС через мобильное приложение
         */
        try {
            Sms::create([
                'smsText' => 'Регистрация пользователя ' . $data['email'],
                'phone' => '+79026223673',
                'smsType' => 1,
                'smsActive' => true
            ]);
        } catch (QueryException $e)
        {

        }
        return User::create([
            'name' => $data['email'],
            'email' => Str::lower($data['email']),
            'password' => Hash::make($data['password']),
        ]);
    }
}
