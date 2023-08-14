@extends('layouts.base')
@section('title', 'Замена картриджей')

@section('info')
    <div class="container">

        <div class="row text-center">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4 border border-2">Филиал</div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4 border border-2 ">Кол-во страниц</div>
        </div>
        @forelse($itog as $value)
            <div class="row text-center">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4 border border-2">{{$value['filial']}}</div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4 border border-2">{{$value['count']}}</div>
            </div>
        @empty
            <div class="row text-center">
                <div class="col-7">Данные по обслуживанию не найдены</div>
            </div>
        @endforelse
        <div class="row-cols-4 p-5"><a class="btn btn-info" href="{{ url()->previous() }}">К списку отчетов</a></div>
    </div>
@endsection('info')
