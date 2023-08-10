@extends('layouts.base')
@section('title', 'Состояние принтеров')

@section('info')

    <div class="container">
        <div class="row text-center">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">№ п/п</div>
            <div class="col-xs-4 col-sm-5 col-md-5 col-lg-4 col-xl-4 col-xxl-4 border border-2">Филиал</div>
            <div class="col-lg-3 col-xl-2 col-xxl-2 border border-2 d-none d-lg-block">IP</div>
            <div class="col-xl-2 col-xxl-2 border border-2 d-none d-xl-block">Статус</div>
            <div class="col-xs-1 col-sm-2 col-md-2 col-lg-1 col-xl-1 col-xxl-1 border border-2">Тонер</div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-1 col-xxl-1 border border-2">Всего</div>
            <div class="col-xs-1 col-sm-2 col-md-2 col-lg-1 col-xl-1 col-xxl-1 border border-2">Сутки</div>
        </div>
        @foreach($device as $id => $value)
        <div class="row text-center">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$loop->index+1}}</div>
            <div class="col-xs-4 col-sm-5 col-md-5 col-lg-4 col-xl-4 col-xxl-4 border border-2">{{$value->filial->name}}</div>
            <div class="col-lg-3 col-xl-2 col-xxl-2 border border-2 d-none d-lg-block">{{$value->ip}}</div>
            <div class="col-xl-2 col-xxl-2 border border-2 d-none d-xl-block">{{$value->status->name}}</div>
            <div class="col-xs-1 col-sm-2 col-md-2 col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$result[$id]['toner']}}</div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-1 col-xxl-1 border border-2">{{$result[$id]['count']}}</div>
            <div class="col-xs-1 col-sm-2 col-md-2 col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$result[$id]['toDayCount']}}</div>
        </div>
        @endforeach
        <div class="row">
            <div class="col-sm-10 col-md-10 col-lg-11 col-xl-11 col-xxl-11 border border-2 text-end">Итого: </div>
            <div class="col-sm-2 col-md-2 col-lg-1 col-xl-1 col-xxl-1 border border-2 text-center">{{$summa}}</div>
        </div>
    </div>



@endsection('info')

