@extends('layouts.base')
@section('title', 'Профиль пользователя')

@section('info')
    <div class="container">
        @if($profile)
        <div class="col-3">
            <label class="col-form-label">Фамилия: <b>{{$profile->last_name}}</b></label>
        </div>
            <div class="col-3">
                <label class="col-form-label">Имя: <b>{{$profile->first_name}}</b></label>
            </div>
            <div class="col-3">
                <label class="col-form-label">Отчество: <b>{{$profile->middle_name}}</b></label>
            </div>
            <div class="col-3">
                <label class="col-form-label">Телефон: <b>{{$profile->phone}}</b></label>
            </div>
            <div class="col-3">
                <label class="col-form-label">Филиал: <b>{{$profile->filial->name}}</b></label>
            </div>
            <div class="col-3">
                <label class="col-form-label">Должность: <b>{{$profile->Post->name}}</b></label>
            </div>
            <div class="col-3">
                <label class="col-form-label">Email: <b>{{$profile->User->email}}</b></label>
            </div>
        @else
            <div class="col-3">
                <label class="col-form-label">Данные отсутствуют</label>
            </div>
        @endif
       <div class="row">
            <div class="col-2">
                <a class="btn btn-info" href="/activation">Назад</a>
            </div>

       </div>
    </div>
@endsection('info')
