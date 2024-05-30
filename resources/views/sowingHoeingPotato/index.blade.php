@extends('layouts.base')
@section('title', 'Контроль нормы высадки картофеля')

@section('info')


    <div class="container gx-4">

        <div class="row">
            @can('viewAny', 'App\Models\sowingcontrolpotato')
                <div class="col-4 p-3"><a class="btn btn-outline-success" href="/sowing_hoeing_potato/create">Внести
                        контроль</a></div>
               {{-- <div class="col-4 p-3"><a class="btn btn-outline-success" href="/spraying/report">Отчеты</a></div>--}}
            @endcan

            @can('viewAny','App\Models\sowingcontrolpotato')
                <div class="col-4 p-3">
                    <div class="dropdown">
                        <button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown">
                            Справочники
                        </button>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item"><a href="/pole">Поля/севооборот</a></li>
                        </ul>
                    </div>

                </div>
            @endcan
        </div>

        <div class="container gx-4">
            <div class="row">
                <div class="col-xl-10">
                    <div class="row">
                        @forelse($sowing_hoeing_potatoes as $filial_name => $sowing_hoeing_potato)
                            <div class="col"> {{$filial_name}}
                                @foreach($sowing_hoeing_potato->groupBy('Pole.name') as $pole_name => $item)
                                    <div><a href="/sowing_hoeing_potato/show_to_pole/{{$item[0]['pole_id']}}?pole_id={{$item[0]['pole_id']}}">{{$pole_name}}</a></div>
                                @endforeach
                            </div>
                        @empty
                            <p>Данные не найдены</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection('info')
