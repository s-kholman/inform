@extends('layouts.base')
@section('title', 'Главная')

@section('info')
    @guest
        <div class="container">
            <div class="bg-light border rounded-3 p-3">
                <h4>Добро пожаловать гость</h4>
                <p>В левой части экрана в меню доступные отчеты</p>
                <p>Для внесения информации необходимо осуществить вход, кнопка находится в верхнем правом углу</p>
                <p>Если данных для входа нет, необходимо пройти регистрацию</p>
            </div>
        </div>

    @endguest
    @auth
        @if(\Illuminate\Support\Facades\Auth::user()->Registration->activation ?? false)
            <div class="container">
                <div class=" bg-light border rounded-3 p-3">
                    <h4>Добро
                        пожаловать {{\Illuminate\Support\Facades\Auth::user()->Registration->first_name .' '. \Illuminate\Support\Facades\Auth::user()->Registration->middle_name}}</h4>
                    <p>В левой части экрана в меню доступные отчеты</p>
                    <p>Если необходимого отчета нет, обратитесь к администратору</p>
                </div>
            </div>
        @elseif(!(\Illuminate\Support\Facades\Auth::user()->Registration->activation ?? false))
            <div class="container">
                <div class=" bg-light border rounded-3 p-3">
                    <h4>Добро пожаловать</h4>
                    <p>Вы зарегистрировались на e-mail: {{\Illuminate\Support\Facades\Auth::user()->email}}. Внесите не
                        достающею информацию в <a href="/profile">"Профиль"</a> Если информация в профиле внесена корректно дождитесь подтверждения от
                        администратора. Подтверждение придет по SMS на номер телефона указанный в профиле</p>
                    <p>Это позволит идентифицировать вас как сотрудника и предоставить необходимый доступ к разделам сайта</p>
                    <p>В левой части экрана в меню доступные вам отчеты</p>
                </div>
            </div>
        @endif

    @endauth
@endsection('info')
