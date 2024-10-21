@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
                <div class="bg-light border rounded-3 p-3">
                <h2>У вас нет прав!!!</h2>
                </div>
                <div class="row-cols-4 p-5"><a class="btn btn-info" href="{{ url()->previous() }}">Назад</a></div>
@endsection('info')
