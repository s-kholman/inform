@extends('layouts.base')
@section('title', 'Справочник')
<style>
    .rotate {
        writing-mode: vertical-rl;
        transform: rotate(-180deg);
        vertical-align: middle;
    }
</style>
@section('info')


    <div class="container">


<div class="row p-1">
    <div class="col-2">
        <a class="btn btn-success" href="/sowing?type=1">Зерновые</a>
    </div>
    <div class="col-2">
        <a class="btn btn-success" href="/sowing?type=2">Картофель</a>
    </div>
    <div class="col-2">
        <a class="btn btn-success" href="/sowing?type=3">Овощи</a>
    </div>
    <div class="col-4">
        @can('viewAdmin', 'App\Models\Sowing')
            <div class="col-2 p-1  dropdown">
                <button type="button" class="btn btn-info dropdown-toggle " data-bs-toggle="dropdown">
                    Действия
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/machine">Агрегаты</a></li>
                    <li><a class="dropdown-item" href="/sowing/type">Тип посева</a></li>
                    <li><a class="dropdown-item" href="/cultivation">Культура</a></li>
                    <li><a class="dropdown-item" href="/sowingLastName">ФИО</a></li>
                    <li><a class="dropdown-item" href="/sowing/outfit/index">Связки на посев</a></li>
                    <li><a class="dropdown-item" href="/shift">Смена</a></li>
                </ul>
            </div>

    @endcan
    </div>
    <div class="col-2">
        <a class="btn btn-info" href="/sowing/create">Внести данные</a>
    </div>
</div>
        <div class="row p-5">
            @forelse($harvest_all as $harvest)
                @if($loop->first)
                    <div class="row">
                        <div class="text-center col-12">
                            Доступны отчеты за следующие периоды:
                        </div>
                    </div>
                @endif

                <div class="col-2">

                    <a href="/sowing?type={{$sowing_type_model->id}}&harvest={{$harvest->id}}">{{$harvest->name}} год</a>
                </div>
            @empty
            @endforelse
        </div>
        @if(!empty($result))
            <div class="row p-2">
                <div class="col-12">

                    <table class="table table-bordered text-center caption-top">
                        <caption class="border text-center">
                            <b><p>Информация за {{$harvest_all->find($harvest_year_id)->name}} год, культура - {{$sowing_type_model->name}} </p></b>
                        </caption>
                        <thead>
                        <tr>
                            <th rowspan="3" ><div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Дата&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></th>
                            @foreach(current($result) as $filial_id => $key)
                                <th colspan="{{\App\Models\Sowing::query()
                                                                ->where('sowing_type_id', $sowing_type_model->id)
                                                                ->where('filial_id', $filial_id)
                                                                ->where('harvest_year_id', $harvest_year_id)
                                                                ->get()
                                                                ->unique('sowing_last_name_id')
                                                                ->count()}}">
                                    {{\App\Models\filial::query()->where('id', $filial_id)->value('name')}}</th>
                            @endforeach
                            <th rowspan="3" class="rotate">Итого за сутки</th>
                        </tr>
                        <tr>
                            @foreach(current($result) as $filial_id => $machine)
                                @foreach($machine as $machine_id => $sowing_last_name)
                                    @if ($no_machine)
                                        <th colspan="{{count($sowing_last_name)}}">{{\App\Models\Cultivation::query()->where('id', $machine_id)->value('name')}}</th>
                                    @else
                                        <th colspan="{{count($sowing_last_name)}}">{{\App\Models\Machine::query()->where('id', $machine_id)->value('name')}}</th>
                                    @endif
                                @endforeach
                            @endforeach
                        </tr>

                        <tr>
                            @foreach(current($result) as $filial_id => $machine)
                                @foreach($machine as $machine_id => $sowing_last_name)
                                    @foreach($sowing_last_name as $sowing_last_name_id => $value)
                                        <th class="rotate">{{\App\Models\SowingLastName::query()->where('id', $sowing_last_name_id)->value('name')}}</th>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tr>

                        </thead>
                        <tbody>

                        @foreach($result as $date => $filial)
                            <tr>
                                <td name="data" class="text-center">{{\Carbon\Carbon::parse($date)->format('d-m-Y')}}</td>
                                @foreach($filial as $filial_id => $machine)
                                    @foreach($machine as $machine_id => $sowing_last_name)
                                        @foreach($sowing_last_name as $sowing_last_name_id => $value)
                                            @if (array_key_exists('default', $value))
                                                <td></td>
                                            @else
                                                @foreach($value as $cultivation_id => $model)
                                                    @if (count($value) > 1)
                                                        @if ($loop->first)
                                                            <td>
                                                                <table> <tbody><tr>
                                                                        @endif
                                                                        <td style="background: {{$model->color}}" class="text-center">{{ $model->volume }}</td>

                                                                        @if ($loop->last)
                                                                    </tr></tbody></table></td>
                                                        @endif
                                                    @else

                                                        <td style="background: {{$model->color}}" >{{$model->volume}}</td>
                                                    @endif

                                                @endforeach
                                            @endif

                                        @endforeach
                                    @endforeach
                                @endforeach
                                <td>{{$summa_arr[$date] ['summa']}}</td>
                            </tr>
                            @if($loop->last)
                        </tbody>
                        <tfoot>
                        <tr>
                            <td>Итого:</td>
                            @foreach($filial as $filial_id => $machine)
                                @foreach($machine as $machine_id => $sowing_last_name)
                                    @foreach($sowing_last_name as $sowing_last_name_id => $value)
                                        <td>
                                            @if($no_machine)
                                                {{round(\App\Models\Sowing::query()
                                                                    ->where('filial_id', $filial_id)
                                                                    ->where('cultivation_id', $machine_id)
                                                                    ->where('sowing_last_name_id', $sowing_last_name_id)
                                                                    ->where('harvest_year_id', $harvest_year_id)
                                                                    ->sum('volume'), 3)}}
                                            @else
                                                {{round(\App\Models\Sowing::query()
                                                                    ->where('filial_id', $filial_id)
                                                                    ->where('machine_id', $machine_id)
                                                                    ->where('sowing_last_name_id', $sowing_last_name_id)
                                                                    ->where('harvest_year_id', $harvest_year_id)
                                                                    ->sum('volume'), 3)}}
                                            @endif
                                        </td>
                                    @endforeach
                                @endforeach
                            @endforeach
                            <td>

                            </td>
                        </tr>
                        @endif
                        @endforeach
                        </tfoot>
                    </table>
                </div>

            </div>
        @else
            <div class="row p-4">
                <div class="col">
                    <p>Нет данных на текущий период. Выберите за предыдущий год или внесите новые данные</p>
                </div>
            </div>
        @endif
    </div>

@endsection('info')
