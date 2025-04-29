@extends('layouts.base')
@section('title', 'Контроль нормы высадки картофеля')

@section('info')


    <div class="container gx-4">

        <div class="row">
            @can('viewAny', 'App\Models\sowingcontrolpotato')
                <div class="col-4 p-3"><a class="btn btn-outline-success" href="/sowing_control_potato/create">Внести
                        контроль</a></div>
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
            <div class="row text-center text-wrap text-break">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        @forelse($sowing_control_potatoes->sortByDesc('HarvestYear.name')->groupBy('HarvestYear.name') as $name => $item)
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
                <div class="tab-content" id="nav-tabContent">
                    @forelse($sowing_control_potatoes->sortByDesc('HarvestYear.name')->groupBy('HarvestYear.name') as $harvest_year_name => $collections)
                        @if($loop->first)
                            <div class="tab-pane fade show active" id="nav-{{$harvest_year_name}}" role="tabpanel"
                                 aria-labelledby="nav-{{$harvest_year_name}}-tab">
                                <div class="row">
                                    @foreach($sowing_control_potatoes->where('harvest_year_id', $collections[0]->harvest_year_id)->groupBy('Filial.name') as $filial_name => $sowing_control_potato)
                                        <div class="col"> {{$filial_name}}
                                            @foreach($sowing_control_potato->groupBy('Pole.name') as $pole_name => $item)
                                                <div>
                                                    <a href="/sowing_control_potato/{{$item[0]['pole_id']}}">{{$pole_name}}</a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                                @else
                                    <div class="tab-pane fade " id="nav-{{$harvest_year_name}}" role="tabpanel"
                                         aria-labelledby="nav-{{$harvest_year_name}}-tab">
                                        <div class="row">
                                            @foreach($sowing_control_potatoes->where('harvest_year_id', $collections[0]->harvest_year_id)->groupBy('Filial.name') as $filial_name => $sowing_control_potato)
                                                <div class="col"> {{$filial_name}}
                                                    @foreach($sowing_control_potato->groupBy('Pole.name') as $pole_name => $item)
                                                        <div>
                                                            <a href="/sowing_control_potato/{{$item[0]['pole_id']}}">{{$pole_name}}</a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                        @endif
                                        @foreach($collections as $sowing_control_potato)
                                        @endforeach
                                    </div>
                                    @empty
                                    @endforelse
                            </div>
                </div>
            </div>

        </div>
    </div>
@endsection('info')
