@extends('layouts.base')
@section('title', 'Справочник')

@section('info')

    <div class="container">

        <div class="row"><h3>{{$currentStatus->filial->name}} - {{$currentStatus->devicename->name}}</h3></div>
        <div class="row"><a href="{{route('printer.current.show', ['id' => $id])}}">История ремонта/перемещения</a></div>
        <div class="row"><a href="{{route('printer.current.edit', ['currentStatus' => $currentStatus])}}">Перемещение/изменение состояния</a></div>
        <div class="row"><a href="/device/{{$currentStatus->id}}/service">Внести ремонт/обслуживание</a></div>
        <div class="row"><a href="/cartridge/{{$id}}">Замена картриджей</a></div>
        <div class="row-cols-4 p-5"><a class="btn btn-info" href="/printers">К списку устройств</a></div>


    </div>

@endsection('info')
