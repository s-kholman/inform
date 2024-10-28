@extends('layouts.base')
@section('title', 'VPN доступ')

@section('info')
    <div class="card w-75 mb-3">
        <div class="card-body">
            <h5 class="card-title">Основные действия:</h5>
            <ol class="list-group list-group-numbered">
                <li class="list-group-item card-text">
                    Распаковать полученный архив. В нем два файла "script_ххххххххххх" и "ssl_ххххххххххх"
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">С начало выполняем файл который начинается на "script_"</div>
                        Для этого необходимо нажать правой кнопки мыши и выбрать пункт <i>"Выполнить с помощью PowerShell"</i>.
                        На все запросы системы отвечать положительно".
                    </div>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Следующим запустить файл начинающийся на "ssl_".</div>
                        Строго-обязательно на первой вкладке выбрать <i>"Локальный компьютер".</i> Далее следовать указаниям системы все пункты оставить по умолчанию
                        <p class="card-text">Пароль для доступа к сертификатам Вы получите по SMS.</p>
                    </div>
                </li>
                <li class="list-group-item card-text">После выполнения данных действий Вы должны получить VPN подключение,
                    ярлык доступа к удаленному компьютеру на рабочем столе и установленные сертификаты доступа.</li>
                <li class="list-group-item card-text">Производим подключение к VPN, если оно успешно, производим подключение к удаленному рабочему месту, пароль Ваш текущий он компьютера предприятия</li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Данные ниже будут использованы для доставки:</div>
                        <b>e-mail:</b>
                        @if(empty($info->vpninfo->mail_send))
                            {{\Illuminate\Support\Facades\Auth::user()->email}}
                        @else
                            {{\Illuminate\Support\Facades\Auth::user()->email . ' копия на '. $info->vpninfo->mail_send}}
                        @endif
                        <br>
                        <b>телефон:</b> {{$info->phone}}
                    </div>
                </li>
            </ol>
        </div>
    </div>
@endsection('info')
