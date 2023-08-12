@extends('layouts.base')
@section('title', 'Замена картриджей')

@section('info')
    <div class="container">

        <div class="row text-center">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">№ п/п</div>
            <div class="col-xs-4 col-sm-5 col-md-5 col-lg-4 col-xl-4 col-xxl-4 border border-2">Дата</div>
            <div class="col-lg-3 col-xl-2 col-xxl-2 border border-2 d-none d-lg-block">Кол-во страниц</div>
        </div>
        @forelse($cartridge as $id => $value)
            <div class="row text-center">
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$loop->index+1}}</div>
                <div class="col-xs-4 col-sm-5 col-md-5 col-lg-4 col-xl-4 col-xxl-4 border border-2">{{$value->date}}</div>
                <div class="col-lg-3 col-xl-2 col-xxl-2 border border-2 d-none d-lg-block">{{$value->count}}</div>
            </div>
        @empty
            <div class="row text-center">
                <div class="col-7">Данные по замене картриджей не найдены</div>
            </div>
        @endforelse
    </div>
@endsection('info')
