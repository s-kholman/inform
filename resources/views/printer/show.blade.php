@extends('layouts.base')
@section('title', 'Справочник')

@section('info')

    <div class="container">
        <div class="row"><a href="{{route('printer.current.show', ['id' => $id])}}">История ремонта/перемещения</a></div>
        <div class="row"><a href="{{route('printer.current.edit', ['currentStatus' => $currentStatus])}}">Перемещение/изменение состояния</a></div>
        <div class="row"><a href="/service_name">Внести ремонт/обслуживание</a></div>
        <div class="row"><a href="/status">Замена картриджей</a></div>

    </div>

@endsection('info')
