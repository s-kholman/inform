@extends('layouts.base')
@section('title',$const['title'])

@section('info')
    <div class="container">

        <div class="row text-center">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">№ п/п</div>
            <div class="col-xs-4 col-sm-5 col-md-5 col-lg-4 col-xl-4 col-xxl-4 border border-2">Модель</div>
            <div class="col-lg-3 col-xl-2 col-xxl-2 border border-2">IP</div>
            <div class="col-xl-2 col-xxl-2 border border-2 d-none d-xl-block">Статус</div>
        </div>
        @foreach($device as $id => $value)
            <div class="row text-center">
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$loop->index+1}}</div>
                <div class="col-xs-4 col-sm-5 col-md-5 col-lg-4 col-xl-4 col-xxl-4 border border-2"><a href={{route('printer.show', ['id' => $value->device_id, 'currentStatus' => $value])}}>{{$value->devicename->name}}</a></div>
                <div class="col-lg-3 col-xl-2 col-xxl-2 border border-2">{{$value->ip}}</div>
                <div class="col-xl-2 col-xxl-2 border border-2 d-none d-xl-block">{{$value->status->name}}</div>
            </div>
        @endforeach
        <div class="row-cols-4 p-5"><a class="btn btn-info" href="{{ url()->previous() }}">К списку отчетов</a></div>
    </div>
@endsection('info')
