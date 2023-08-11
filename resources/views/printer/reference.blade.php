@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <div class="container">
        <div class="row"><a href="/device_name">Модели и OID</a></div>
        <div class="row"><a href="/brend">Бренд</a></div>
        <div class="row"><a href="/service_name">Наименование работ</a></div>
        <div class="row"><a href="/status">Статусы устройства</a></div>

    </div>

@endsection('info')
