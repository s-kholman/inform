@extends('layouts.base')
@section('title', 'Контроль окучивания картофеля')
<style>
    .rotate {
        writing-mode: vertical-rl;
        -moz-transform: scale(-1, -1);
        -webkit-transform: scale(-1, -1);
        -o-transform: scale(-1, -1);
        -ms-transform: scale(-1, -1);
        transform: scale(-1, -1);
        height: 155px;
    }

    .vertical-align{
        vertical-align: middle;
    }
</style>
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
                        @forelse($sowing_hoeing_potatoes->groupBy('Filial.name') as $filial_name => $sowing_hoeing_potato)
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

        <div class="row p-4">
            <table class="table table-bordered text-center table-striped">
                <thead>
                <tr>
                    <th rowspan="2">Дата</th>
                    {!! $string_filial !!}
                </tr>
                <tr>
                    {!! $string_pole !!}
                </tr>
                </thead>
                <tbody>
                @foreach($detail as $date => $key)
                    <tr><td>{{\Carbon\Carbon::parse($date)->translatedFormat('d-m-Y')}}</td>
                        @foreach($key as $volume)
                            <td>{{$volume ?: ''}}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>

                <tfoot>
                <tr>
                    <td>Итого:</td>
                    @foreach($detail as $det)
                        @foreach($det as $key => $volume)
                            <td>{{$detail->sum($key)}}</td>
                        @endforeach
                        @break
                @endforeach
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection('info')
