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
    .vertical-align {
        vertical-align: middle;
    }
</style>
@section('info')


    <div class="container gx-4">

        <div class="row">
            @can('viewAny', 'App\Models\sowingcontrolpotato')
                <div class="col-4 p-3"><a class="btn btn-outline-success" href="/sowing_hoeing_potato/create">Внести
                        контроль</a>
                </div>
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

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                @forelse($sowing_hoeing_potatoes->sortByDesc('HarvestYear.name')->groupBy('HarvestYear.name') as $name => $item)
                    @if($loop->first)
                        <button class="nav-link active" id="nav-{{$name}}-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-{{$name}}" type="button" role="tab"
                                aria-controls="nav-{{$name}}" aria-selected="true">{{$name}}</button>
                    @else
                        <button class="nav-link" id="nav-{{$name}}-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-{{$name}}" type="button" role="tab"
                                aria-controls="nav-{{$name}}" aria-selected="false">{{$name}}</button>
                    @endif
                @empty
                @endforelse
            </div>
        </nav>

        @forelse($sowing_hoeing_potatoes->sortByDesc('HarvestYear.name')->groupBy('HarvestYear.name') as $harvest_year_name => $collections)

            @if($loop->first)
                <div class="tab-content" id="nav-tabContent">@endif
                    <div class="tab-pane fade @if($loop->first) show active @endif" id="nav-{{$harvest_year_name}}" role="tabpanel"
                         aria-labelledby="nav-{{$harvest_year_name}}-tab">
                        <div class="row">
                            @foreach($sowing_hoeing_potatoes->where('harvest_year_id', $collections[0]->harvest_year_id)->groupBy('Filial.name') as $filial_name => $sowing_control_potato)
                                <div class="col"> {{$filial_name}}
                                    @foreach($sowing_control_potato->groupBy('Pole.name') as $pole_name => $item)
                                        <div>
                                            <a href="/sowing_hoeing_potato/show_to_pole/{{$item[0]['pole_id']}}">{{$pole_name}}</a>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                            <div class="row p-4">
                                <table class="table table-bordered text-center table-striped caption-top">
                                    <caption class="border text-center">
                                        Сводная по окучиванию - {{$harvest_year_name}}
                                    </caption>
                                    <thead>
                                    <tr>
                                        <th rowspan="2">Дата</th>
                                        {{--{!! $string_filial[$harvest_year_name] !!}--}}
                                        @foreach($collections->groupBy('Filial.name') as $name => $value)
                                            <th colspan="{{$value->groupBy('Pole.name')->count()}}">{{$name}}</th>
                                        @endforeach

                                    </tr>

                                    <tr>
                                        @foreach($collections->groupBy('Filial.name') as $name => $value)
                                            @foreach($value->groupBy('Pole.name') as $pole)
                                                <th class="vertical-align">
                                                    <label class="rotate">{{ $pole[0]->Pole->name}}</label>
                                                </th>
                                            @endforeach
                                        @endforeach

                                    </tr>

                                    </thead>
                                    <tbody>

                                        @foreach(collect($detail[$harvest_year_name])->sortKeysDesc() as $date => $key)
                                            <tr>
                                                <td>{{\Carbon\Carbon::parse($date)->translatedFormat('d-m-Y')}}</td>
                                                @foreach($collections->groupBy('Pole.name') as $value)
                                                    <td>{{$detail [$harvest_year_name] [$date] [$value[0]->Pole->id] ?? ''}}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach

                                    </tbody>


                                    <tfoot>
                                    <tr>
                                        <th>Итого:</th>
                                        @foreach($collections->groupBy('Pole.name') as $value)
                                            <th>
                                                {{ $collections->where('HarvestYear.name',
                                                $harvest_year_name)->where('Pole.name',
                                                $value[0]->Pole->name)->sum('volume')}}
                                            </th>
                                        @endforeach
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
    </div>
@endsection('info')
