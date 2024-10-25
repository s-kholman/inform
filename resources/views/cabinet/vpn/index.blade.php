@extends('layouts.base')
@section('title', 'VPN доступ')

@section('info')
    <div class="card w-75 mb-3">
        <div class="card-body">
            <h5 class="card-title">Инструкция в разработке. Основные действия:</h5>
            <p class="card-text">Распаковать полученный архив.</p>
            <p class="card-text">Первым запустить файл который начинается со "script_".</p>
            <p class="card-text">Вторым запустить файл начинающийся на с "ssl_".</p>
            <p class="card-text">Строго-обязательно на первой вкладке выбрать "Локальный компьютер". Далее все по умолчанию</p>
            <p class="card-text">Пароль Вы получите по SMS.</p>
            <p class="card-text">Вы должны получить VPN подключение, файл на рабочем столе и установленные сертификаты доступа.</p>
        </div>
    </div>
@endsection('info')
