@extends('layouts.base')

@section('title', 'Контроль окучивания картофеля')

@section('info')
    <div class="container">
        <div class="row text-center text-wrap text-break">


            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @forelse($sowing_hoeing_potatoes->groupBy('HarvestYear.name') as $name => $item)
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

                @forelse($sowing_hoeing_potatoes->groupBy('HarvestYear.name') as $harvest_year_name => $collections)

                    @if($loop->first)

                        <div class="tab-pane fade show active" id="nav-{{$harvest_year_name}}" role="tabpanel"
                             aria-labelledby="nav-{{$harvest_year_name}}-tab">
                            <table class="table table-bordered table-striped">
                                <caption class="border rounded-3 p-3 caption-top">
                                    <p class="text-center">
                                        Сводная по оценке качества: поле - <b>{{$collections[0]->Pole->name}}</b>,
                                        филиала - <b>{{$collections[0]->Filial->name}}</b>
                                    </p>
                                </caption>
                                <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">Дата</th>
                                    <th rowspan="2" class="text-center">Механизатор</th>
                                    <th rowspan="2" class="text-center">Вид работ</th>
                                    <th rowspan="2" class="text-center">Смена</th>
                                    <th rowspan="2" class="text-center">Га</th>
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
                                    <div class="tab-pane fade " id="nav-{{$harvest_year_name}}" role="tabpanel"
                                         aria-labelledby="nav-{{$harvest_year_name}}-tab">
                                        <table class="table table-bordered table-striped">
                                            <caption class="border rounded-3 p-3 caption-top">
                                                <p class="text-center">
                                                    Отчет по оценке качества: поле -
                                                    <b>{{$collections[0]->Pole->name}}</b>, филиала -
                                                    <b>{{$collections[0]->Filial->name}}</b>
                                                </p>
                                            </caption>
                                            <thead>
                                            <tr>
                                                <th rowspan="2" class="text-center">Дата</th>
                                                <th rowspan="2" class="text-center">Механизатор</th>
                                                <th rowspan="2" class="text-center">Вид работ</th>
                                                <th rowspan="2" class="text-center">Смена</th>
                                                <th rowspan="2" class="text-center">Га</th>
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

                                            @foreach($collections as $sowing_hoeing_potato)

                                                <tr>
                                                    <td align="center">{{\Carbon\Carbon::parse($sowing_hoeing_potato->date)->translatedFormat('d-m-Y')}}</td>
                                                    <td>{{$sowing_hoeing_potato->SowingLastName->name}}</td>
                                                    <td align="center">{{$sowing_hoeing_potato->TypeFieldWork->name}}</td>
                                                    <td align="center">{{$sowing_hoeing_potato->Shift->name}}</td>
                                                    <td align="center">{{$sowing_hoeing_potato->volume}}</td>
                                                    <td align="center">{{\App\Models\HoeingResult::query()->where('id' ,$sowing_hoeing_potato->hoeing_result_agronomist)->value('name') ??   ''}}</td>
                                                    <td align="center">{{\App\Models\HoeingResult::query()->where('id' ,$sowing_hoeing_potato->hoeing_result_director)->value('name') ??   ''}}</td>
                                                    <td align="center">{{\App\Models\HoeingResult::query()->where('id' ,$sowing_hoeing_potato->hoeing_result_deputy_director)->value('name') ??   ''}}</td>
                                                    <td align="center">{!!nl2br($sowing_hoeing_potato->comment)!!}</td>
                                                    <td align="center">
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                    class="btn btn-sm btn-outline-info dropdown-toggle"
                                                                    data-bs-toggle="dropdown">
                                                                Действия
                                                            </button>

                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item text-info"
                                                                       href="/sowing_hoeing_potato/{{$sowing_hoeing_potato->id}}/edit">Редактировать</a>
                                                                </li>

                                                                <form class="delete-message"
                                                                      data-route="{{route('sowing_hoeing_potato.destroy', ['sowing_hoeing_potato' => $sowing_hoeing_potato->id])}}"
                                                                      method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <li><input type="submit"
                                                                               class="dropdown-item text-danger"
                                                                               value="Удалить"></li>
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
                <a class="btn btn-outline-success" href="/sowing_hoeing_potato/create">Внести контроль</a>
            </div>
            <div class="p-4 col-5">
                <a class="btn btn-outline-success" href="/sowing_hoeing_potato">К списку полей</a>
            </div>
        </div>
    </div>
@endsection('info')

@section('script')
    @include('scripts\destroy-modal')
@endsection
