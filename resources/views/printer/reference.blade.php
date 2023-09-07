@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <div class="container">
        <div class="row"><a href="/device_name">Модели и OID</a></div>
        <div class="row"><a href="/brend">Бренд</a></div>
        <div class="row"><a href="/service_name">Наименование работ</a></div>
        <div class="row"><a href="/status">Статусы устройства</a></div>
        <div class="row"><a href="/mibOid">Внесение MID OID</a></div>
        <div class="row"><a href="/service">Резерв / ремонт </a></div>
        <div class="row"><a href="/device">Добавить новое устройство</a></div>
        <div class="row"><a href="/service/show">Устройства на обслуживание</a></div>
        <div class="row-cols-4 p-5"><a class="btn btn-info" href="/printers">К списку устройств</a></div>
    </div>

@endsection('info')
