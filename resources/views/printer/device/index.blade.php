@extends('layouts.base')
@section('title', 'Устройства')

@section('info')
    <div class="container">

        <div class="row">
            <div class="col"><a href="\device\create">Добавить новое устройство</a> </div>
        </div>

        <div class="row text-center">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">№ п/п</div>
            <div class="col-xs-4 col-sm-5 col-md-5 col-lg-4 col-xl-4 col-xxl-4 border border-2">MAC</div>
            <div class="col-lg-3 col-xl-2 col-xxl-2 border border-2">SN</div>
            <div class="col-xl-2 col-xxl-2 border border-2 d-none d-xl-block">Модель</div>
            <div class="col-xl-2 col-xxl-2 border border-2 d-none d-xl-block">Перемещение</div>
        </div>
        @foreach(\App\Models\Device::all() as $id => $value)
            <div class="row text-center">
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$loop->index+1}}</div>
                <div class="col-xs-4 col-sm-5 col-md-5 col-lg-4 col-xl-4 col-xxl-4 border border-2">{{$value->mac}}</a></div>
                <div class="col-lg-3 col-xl-2 col-xxl-2 border border-2 ">{{$value->sn}}</div>
                <div class="col-xl-2 col-xxl-2 border border-2 d-none d-xl-block"><a href="\device\{{$value->id}}\edit">{{$value->modelName->name}}</a></div>
                <div class="col-xl-2 col-xxl-2 border border-2 d-none d-xl-block"><a href="\current\{{$value->id}}\edit">Переместить</a> </div>
            </div>
        @endforeach
        <div class="row-cols-4 p-5"><a class="btn btn-info" href="/reference">К списку справочников</a></div>
    </div>
@endsection('info')
