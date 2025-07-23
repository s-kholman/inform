@extends('layouts.base')
@section('title', 'Пропуск на филиалы АФ-КРиММ')

@section('info')

    <div class="container gx-4">
        <div>
            <a class="btn btn-info" href="/">Выйти</a>
        </div>
        <div class="mt-3" style="color: {{$color}}">
            <h3>{{$message}}</h3>
        </div>
    </div>
@endsection('info')
