@extends('layouts.base')
@section('title', 'Мониторинг температуры в боксах')
<style>
    .rotate {
        writing-mode: vertical-rl;
        -moz-transform: scale(-1, -1);
        -webkit-transform: scale(-1, -1);
        -o-transform: scale(-1, -1);
        -ms-transform: scale(-1, -1);
        transform: scale(-1, -1);
        height: 150px;
    }

    .vertical-align{
        vertical-align: middle;
    }
    .background-color-director{
        background-color: #f3f9ff;
    }
</style>
@section('info')
    <div class="container">

        <div class="row mb-3">
            <div class="col-5">
                <h4>{{$monitoring[0]->storageName->name}}</h4>
            </div>
        </div>

        <div class="row mb-3">
            @canany(['ProductMonitoring.director.create', 'ProductMonitoring.completed.create'])
                <div class="col-4 ">
                    <a class="btn btn-info" href="/monitoring/create">Внести данные</a>
                </div>
            @endcanany
            <div class="col-4">
                <a class="btn btn-secondary" href="{{route('monitoring.show.filial', ['filial_id' => $monitoring[0]->storageName->filial_id, 'harvest_year_id' => $monitoring[0]->harvest_year_id])}}">Назад</a>
            </div>
                @canany(['ProductMonitoring.director.create', 'ProductMonitoring.deploy.create'])
                <div class="col-4">
                    <a class="btn btn-outline-primary" href="{{route('monitoring.control.storage', ['storage_id' => $monitoring[0]->storage_name_id, 'harvest_year_id' => $monitoring[0]->harvest_year_id])}}">Контроль</a>
                </div>
                @endcanany

                @if($visibleButton > 0)
                <div class="col-4 mt-2">
                    <a class="btn btn-outline-primary" href="{{route('product.monitoring.devices.show.storage', ['id' => $monitoring[0]->storage_name_id, 'year' => $monitoring[0]->harvest_year_id])}}">Автоматический контроль</a>
                </div>
                @endif

        </div>

        <table class="table table-bordered text-center">
            <tr>
                <th rowspan="2" style="vertical-align: middle">Дата</th>
                <th colspan="4" style="background-color: #f3f9ff">Рекомендация хранения</th>
                <th colspan="4">Работа исполнителя</th>
                <th rowspan="2" class="vertical-align"><label class="rotate">Контроль директор</label></th>
                <th rowspan="2" class="vertical-align"><label class="rotate">Контроль зам. ген. дир</label></th>
            </tr>
            <tr>
                <th class="vertical-align" style="background-color: #f3f9ff"><label class="rotate">Фаза хранения</label></th>
                <th class="vertical-align" style="background-color: #f3f9ff"><label class="rotate">Режим работы вентиляции</label></th>
                <th class="vertical-align" style="background-color: #f3f9ff"><label class="rotate">Температура хранения</label></th>
                <th class="vertical-align" style="background-color: #f3f9ff"><label class="rotate">Влажность хранения</label></th>
                <th class="vertical-align"><label class="rotate">Температура клубня</label></td>
                <th class="vertical-align"><label class="rotate">Влажность в боксе</label></th>
                <th class="vertical-align"><label class="rotate">Конденсат</label></td>
                <th class="vertical-align"><label class="rotate">Комментарий</label></th>
            </tr>

            @foreach($monitoring as $id => $value)
                <tr>
                    <td>
                        @can(['ProductMonitoring.director.create'])
                            <a href="/monitoring/{{$value->id}}/edit">{{\Carbon\Carbon::parse($value->date)->format('d-m-Y')}}</a>
                        @else
                            {{\Carbon\Carbon::parse($value->date)->format('d-m-Y')}}
                        @endcan
                    </td>
                    <td style="background-color: #f3f9ff">{{$value->phase->name ?? ''}}</td>
                    <td  style="background-color: #f3f9ff" class="text-nowrap">
                        @can('ProductMonitoring.director.create')
                                @forelse(\App\Models\StorageMode::where('product_monitoring_id', $value->id)->orderby('timeUp')->get() as $mode)
                                            <a href="/monitoring/mode/show/{{$mode->id}}">{{\Carbon\Carbon::parse($mode->timeUp)->format('H:i')}} {{\Carbon\Carbon::parse($mode->timeDown)->format('H:i')}}</a> <br>
                                @empty
                            @endforelse
                        @else
                                @forelse(\App\Models\StorageMode::where('product_monitoring_id', $value->id)->orderby('timeUp')->get() as $mode)
                                            {{\Carbon\Carbon::parse($mode->timeUp)->format('H:i')}} {{\Carbon\Carbon::parse($mode->timeDown)->format('H:i')}}<br>
                                @empty
                            @endforelse
                        @endcan
                    </td>
                    <td style="background-color: #f3f9ff">{{$value->temperature_keeping}} @if($value->temperature_keeping <> '')&degС@endif</td>
                    <td style="background-color: #f3f9ff">{{$value->humidity_keeping}}</td>
                    <td class="@if((isset($value->phase->StoragePhaseTemperature->temperature_min) && $value->tuberTemperatureMorning < $value->phase->StoragePhaseTemperature->temperature_min ?? ''
                                                    || $value->tuberTemperatureMorning > $value->phase->StoragePhaseTemperature->temperature_max ?? '')
                                                    && $value->tuberTemperatureMorning <> null) bg-danger @endif" >
                        {{$value->tuberTemperatureMorning}} @if($value->tuberTemperatureMorning <> '')&degС@endif</td>
                    <td>{{$value->humidity}}</td>
                    <td class="text-center @if($value->condensate) bg-danger @endif">
                        @if($value->condensate)
                            +
                        @endif</td>
                    <td>{{$value->comment}}</td>
                    <td style="color: #ffd300">
                        @forelse($value->productMonitoringControl as $text)
                            @if($text->level == 1)
                                <label style="color: black">{{\App\Models\Registration::query()->where('user_id', $text->user_id)->value('last_name')}}:</label>   {{$text->text}}
                            @endif
                        @empty
                        @endforelse
                    </td>
                    <td style="color: #d00101" >
                        @forelse($value->productMonitoringControl as $text)
                            @if($text->level == 2)
                                <label style="color: black">{{\App\Models\Registration::query()->where('user_id', $text->user_id)->value('last_name')}}:</label>   {{$text->text}}
                            @endif
                        @empty
                        @endforelse
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="row p-4">
            {{$monitoring->links()}}
        </div>
    </div>
@endsection('info')

