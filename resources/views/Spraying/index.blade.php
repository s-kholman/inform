@extends('layouts.base')
@section('title', 'Текущие данные об опрыскивание ')

@section('info')

    @can('viewAny', 'App\Models\spraying')
        <div class="container gx-4">
            <div class="row">
                <div class="col-4 p-3"></div>
                <div class="col-4 p-3" ><a class="btn btn-outline-success" href="{{route('spraying.create')}}">Внести опрыскивание</a></div>
                <div class="col-4 p-3"><a class="btn btn-outline-success" href="/spraying/report">Отчеты</a> </div>
            </div>
        </div>
    @endcan



<div class="container gx-4">
    <div class="row  ">

        <div class="col-xl-2 border border-1">
            <p>Справочники</p>
            <div><a href="/pole">Поля/севооборот</a></div>
            <div><a href="/nomenklature">Номенклатура</a></div>
            <div><a href="/szr">СЗР</a></div>
        </div>

        <div class="col-xl-10">
            <div class="row">
                            @foreach($arr as $filial => $name)
                            <div class="col"> {{$filial}}
                                @foreach($name as $item)
                                    <div>  <a href="spraying/{{$item['pole']['id']}}">{{$item['pole']['name']}}</a></div>
                                @endforeach
                            </div>
                                @endforeach
            </div>
        </div>

    </div>
</div>



@endsection('info')
