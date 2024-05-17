@extends('layouts.base')

@section('title', 'Контроль нормы высадки картофеля')

@section('info')
    <div class="container">
        <div class="row text-center text-wrap text-break">


                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        @forelse($sowing_control_potatoes->groupBy('HarvestYear.name') as $name => $item)
                            @if($loop->first)
                                <button class="nav-link active" id="nav-{{$name}}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{$name}}" type="button" role="tab" aria-controls="nav-{{$name}}" aria-selected="true">{{$name}}</button>
                            @else
                                <button class="nav-link" id="nav-{{$name}}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{$name}}" type="button" role="tab" aria-controls="nav-{{$name}}" aria-selected="false">{{$name}}</button>
                            @endif
                        @empty
                        @endforelse
                    </div>
                </nav>

            <div class="tab-content" id="nav-tabContent">

            @forelse($sowing_control_potatoes->groupBy('HarvestYear.name') as $harvest_year_name => $collections)

                @if($loop->first)

                        <div class="tab-pane fade show active"  id="nav-{{$harvest_year_name}}" role="tabpanel" aria-labelledby="nav-{{$harvest_year_name}}-tab">
                        <table class="table table-bordered table-striped">
                            <caption class="border rounded-3 p-3 caption-top">
                                <p class="text-center">
                                    Сводная по оценке качества: поле - <b>{{$collections[0]->Pole->name}}</b>, филиала - <b>{{$collections[0]->Filial->name}}</b>
                                </p>
                            </caption>
                            <thead>
                            <tr>
                            <th rowspan="2"  class="text-center">Дата</th>
                            <th rowspan="2" class="text-center">Механизатор</th>
                            <th rowspan="2" class="text-center">Вид работ</th>
                            <th rowspan="2" class="text-center">Точка контроля</th>
                            <th colspan="3" class="text-center">Результат контроля</th>
                            <th rowspan="2" class="text-center">Комментарий</th>
                            <th rowspan="2" class="text-center">Действия</th>
                            </tr>
                            <tr>
                                <th class="text-center">Агроном</th>
                                <th class="text-center">Директор</th>
                                <th class="text-center">зам. ген. дир.</th>
                            </tr>
                            </thead>

                            @else
                                <div class="tab-pane fade "  id="nav-{{$harvest_year_name}}" role="tabpanel" aria-labelledby="nav-{{$harvest_year_name}}-tab">
                                <table class="table table-bordered table-striped">
                                    <caption class="border rounded-3 p-3 caption-top">
                                        <p class="text-center">
                                            Отчет по оценке качества: поле - <b>{{$collections[0]->Pole->name}}</b>, филиала - <b>{{$collections[0]->Filial->name}}</b>
                                        </p>
                                    </caption>
                                    <thead>
                                    <tr>
                                        <th rowspan="2"  class="text-center">Дата</th>
                                        <th rowspan="2" class="text-center">Механизатор</th>
                                        <th rowspan="2" class="text-center">Вид работ</th>
                                        <th rowspan="2" class="text-center">Точка контроля</th>
                                        <th colspan="3" class="text-center">Результат контроля</th>
                                        <th rowspan="2" class="text-center">Комментарий</th>
                                        <th rowspan="2" class="text-center">Действия</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Агроном</th>
                                        <th class="text-center">Директор</th>
                                        <th class="text-center">зам. ген. дир.</th>
                                    </tr>
                                    </thead>

                @endif
                                    <tbody>

                    @foreach($collections as $sowing_control_potato)

                <tr>
                    <td align="center">{{$sowing_control_potato->date}}</td>
                    <td>{{$sowing_control_potato->SowingLastName->name}}</td>
                    <td align="center">{{$sowing_control_potato->TypeFieldWork->name}}</td>
                    <td align="center">{{$sowing_control_potato->point_control}}</td>
                    <td align="center">{{$sowing_control_potato->result_control_agronomist}}</td>
                    <td align="center">{{$sowing_control_potato->result_control_director}}</td>
                    <td align="center">{{$sowing_control_potato->result_control_deputy_director}}</td>
                    <td align="center">{!!nl2br($sowing_control_potato->comment)!!}</td>
                    <td align="center">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle" data-bs-toggle="dropdown">
                                        Действия
                                    </button>

                                    <ul class="dropdown-menu">
                                            <li><a class="dropdown-item text-info" href="/sowing_control_potato/{{$sowing_control_potato->id}}/edit">Редактировать</a></li>

                                        <form class="delete-message" data-route="{{route('sowing_control_potato.destroy', ['sowing_control_potato' => $sowing_control_potato->id])}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <li><input type="submit" class="dropdown-item text-danger" value="Удалить"></li>
                                        </form>
                                    </ul>
                                </div>
                    </td>
                </tr>
                @if($loop->last)
                                    </tbody>
                                </table>
                                    @endif
                @endforeach

                                </div>

            @empty
            @endforelse
                        </div>
            </div>

        </div>
        <div class="m-5 row">
            <div class="p-4 col-5">
                <a class="btn btn-outline-success" href="/sowing_control_potato/create">Внести контроль</a>
            </div>
            <div class="p-4 col-5">
                <a class="btn btn-outline-success" href="/sowing_control_potato/index">К списку полей</a>
            </div>
        </div>
    </div>
@endsection('info')

@section('script')
    @include('scripts\destroy-modal')
@endsection