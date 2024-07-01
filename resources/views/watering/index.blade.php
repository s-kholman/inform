@extends('layouts.base')

@section('title', 'Данные о поливе ')

@section('info')
    <div class="container">
        <div class="row">
            @can('viewAny', 'App\Models\watering')
                <div class="col-4 p-3"><a class="btn btn-outline-success" href="/watering/create">Внести полив</a></div>
            @endcan

            <div class="col-4 p-3">


                <div class="dropdown">
                    <button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown">
                        Справочники
                    </button>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a href="/pole">Поля/севооборот</a></li>
                        @can('myView', 'App\Models\watering')
                            <li class="dropdown-item"><a href="/nomenklature">Номенклатура</a></li>
                            <li class="dropdown-item"><a href="/szr">СЗР</a></li>
                        @endcan
                    </ul>
                </div>

            </div>

        </div>

        <div class="row">
            @forelse($pole as $filial_name => $pole)
                <div class="col">
                    <b>{{$filial_name}}</b>
                    @foreach($pole as $pole_name => $temp)
                        <br><a href="/watering/show/{{$temp[0]->filial_id}}/{{$temp[0]->pole_id}}">{{$pole_name}}</a>
                    @endforeach
                </div>
            @empty
            @endforelse
        </div>
    </div>
@endsection('info')
