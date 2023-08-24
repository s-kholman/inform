@extends('layouts.base')
@section('title', 'Текущие используемые связки')

@section('info')
    <div class="container">
        <div class="row">
            <div class="col-4 p-2">
                <a class="btn btn-primary " href="/">На главную</a>
            </div>
            <div class="col-4 p-2">
                <a class="btn btn-primary " href="/svyaz/create">Добавить</a>
            </div>
        </div>
        <div class="row">
            <div class="col-2">Филиал</div>
            <div class="col-2">Агрегат</div>
            <div class="col-2">ФИО</div>
            <div class="col-2">Вид</div>
            <div class="col-2">Дата</div>
            <div class="col-2">Статус</div>
        </div>
        @forelse(\App\Models\svyaz::all() as $svyaz)
            <div class="row">
                <div class="col-2">{{ $svyaz->filial->name }}</div>
                <div class="col-2">{{ $svyaz->agregat->name }}</div>
                <div class="col-2">{{ $svyaz->fio->name }}</div>
                <div class="col-2">{{ $svyaz->vidposeva->name }}</div>
                <div class="col-2">{{ $svyaz->date }}</div>
                <div class="col-2"><a href="\svyaz\{{$svyaz->id}}">{{ $svyaz->active ? 'Активно' : 'Закрыта'}}</a></div>
            </div>
        @empty
        @endforelse
    </div>
@endsection('info')

