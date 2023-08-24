@extends('layouts.base')
@section('title', 'Редактирование связок по посеву')

@section('info')
    <div class="container">
        <div class="row">
            <div class="col-2">Филиал</div>
            <div class="col-2">Агрегат</div>
            <div class="col-2">ФИО</div>
            <div class="col-2">Вид</div>
            <div class="col-2">Дата</div>
        </div>
        <div class="row">
            <div class="col-2">{{ $svyaz->filial->name }}</div>
            <div class="col-2">{{ $svyaz->agregat->name }}</div>
            <div class="col-2">{{ $svyaz->fio->name }}</div>
            <div class="col-2">{{ $svyaz->vidposeva->name }}</div>
            <div class="col-2">{{ $svyaz->date }}</div>
        </div>
        <div class="row p-6">
            <div class="col-4 p-2">
                <form action="{{ route('svyaz.destroy', ['svyaz' => $svyaz])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-danger" value="Удалить">
                </form>
            </div>
            <div class="col-4 p-2">
                <form action="{{ route('svyaz.update', ['svyaz' => $svyaz])}}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="submit" class="btn btn-info" value="{{$svyaz->active ? "Деактивировать" : "Активировать"}}">
                    <input hidden name="active" value="{{$svyaz->active ? 0 : 1}}">
                </form>
            </div>
            <div class="col-4 p-2">
                <a class="btn btn-primary " href="/svyaz">Назад</a>
            </div>
        </div>
    </div>

@endsection('info')

