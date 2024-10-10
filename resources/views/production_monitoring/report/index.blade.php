@extends('layouts.base')
@section('title', 'Отчет - мониторинг температуры хранения продукции')
<style>
    .rotate {
        writing-mode: vertical-rl;
        -moz-transform: scale(-1, -1);
        -webkit-transform: scale(-1, -1);
        -o-transform: scale(-1, -1);
        -ms-transform: scale(-1, -1);
        transform: scale(-1, -1);
        height: 170px;
    }

    .vertical-align {
        vertical-align: middle;
    }

    .background-color-director {
        background-color: #f3f9ff;
    }
</style>
@section('info')

    <div class="container">
        <form action="{{route('monitoring.report.day')}}" method="POST">
            <div class="row justify-content-center text-center">
                @csrf
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-2 col-xxl-2">
                    <label for="dateSelect">Выберите дату</label>
                    <input class="form-control"
                           type="date"
                           name="date"
                           value="{{\Illuminate\Support\Carbon::parse($date)->format('Y-m-d')}}"
                           id="dateSelect">
                </div>
            </div>
            <div class=" justify-content-center row p-4">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2"></div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-2 col-xxl-2">
                    <input class="btn btn-primary" type="submit" value="Сформировать">
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-2 col-xxl-2">
                    <a class="btn btn-info" href="/monitoring/">Назад</a>
                </div>
            </div>
        </form>
    </div>

    @if($show == 1)
        <div class="container px-5">
            <div class="row row-cols-2 gy-5">
                <div class="col-12">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            @forelse($arr_value as $filial_id => $item)
                                @if ($loop->first)
                                    <button class="nav-link active" id="nav-{{$filial_id}}-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-{{$filial_id}}" type="button" role="tab"
                                            aria-controls="nav-{{$filial_id}}"
                                            aria-selected="true">{{$item[0]->filial->name}}</button>
                                @else
                                    <button class="nav-link" id="nav-{{$filial_id}}-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-{{$filial_id}}" type="button" role="tab"
                                            aria-controls="nav-{{$filial_id}}"
                                            aria-selected="false">{{$item[0]->filial->name}}</button>
                                @endif
                            @empty
                            @endforelse
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        @forelse($arr_value as $filial_id => $item)
                            @if ($loop->first)
                                <div class="tab-pane fade show active" id="nav-{{$filial_id}}" role="tabpanel"
                                     aria-labelledby="nav-{{$filial_id}}-tab">
                                    @else
                                        <div class="tab-pane fade " id="nav-{{$filial_id}}" role="tabpanel"
                                             aria-labelledby="nav-{{$filial_id}}-tab">
                                            @endif
                                            <table class="table table-bordered text-center">
                                                <tr>
                                                    <td colspan="11"><b>{{$item[0]->filial->name}}
                                                            на
                                                            {{\Illuminate\Support\Carbon::parse($date)->format('d-m-Y')}}</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle">Бокс</th>
                                                    <th colspan="4" style="background-color: #f3f9ff">Рекомендация
                                                        хранения
                                                    </th>
                                                    <th colspan="4">Работа исполнителя</th>
                                                    <th rowspan="2" class="vertical-align"><label class="rotate">Контроль
                                                            директор</label></th>
                                                    <th rowspan="2" class="vertical-align"><label class="rotate">Контроль
                                                            зам. ген.
                                                            дир</label></th>
                                                </tr>
                                                <tr>
                                                    <th class="vertical-align" style="background-color: #f3f9ff"><label
                                                            class="rotate">Фаза
                                                            хранения</label></th>
                                                    <th class="vertical-align" style="background-color: #f3f9ff"><label
                                                            class="rotate">Режим
                                                            работы вентиляции</label></th>
                                                    <th class="vertical-align" style="background-color: #f3f9ff"><label
                                                            class="rotate">Температура
                                                            хранения</label></th>
                                                    <th class="vertical-align" style="background-color: #f3f9ff"><label
                                                            class="rotate">Влажность
                                                            хранения</label></th>
                                                    <th class="vertical-align"><label class="rotate">Температура
                                                            клубня</label>
                                                    </td>
                                                    <th class="vertical-align"><label class="rotate">Влажность в
                                                            боксе</label></th>
                                                    <th class="vertical-align"><label class="rotate">Конденсат</label>
                                                    </td>
                                                    <th class="vertical-align"><label class="rotate">Комментарий</label>
                                                    </th>
                                                </tr>


                                                @foreach($item as $value)
                                                    <tr>
                                                        <td>{{$value->storageName->name}}</td>
                                                        <td style="background-color: #f3f9ff">{{$value->phase->name ?? ''}}</td>
                                                        <td style="background-color: #f3f9ff" class="text-nowrap">
                                                            @forelse($value->Mode as $mode)
                                                                {{\Carbon\Carbon::parse($mode->timeUp)->format('H:i')}}
                                                                - {{\Carbon\Carbon::parse($mode->timeDown)->format('H:i')}}
                                                                ; <br>
                                                            @empty
                                                                н/д
                                                            @endforelse
                                                        </td>
                                                        <td style="background-color: #f3f9ff">{{$value->temperature_keeping}}@if($value->temperature_keeping <> '')
                                                                &degС@endif</td>
                                                        <td style="background-color: #f3f9ff">{{$value->humidity_keeping}}</td>
                                                        <td class="@if((isset($value->phase->StoragePhaseTemperature->temperature_min) && $value->tuberTemperatureMorning < $value->phase->StoragePhaseTemperature->temperature_min ?? ''
                                                    || $value->tuberTemperatureMorning > $value->phase->StoragePhaseTemperature->temperature_max ?? '')
                                                    && $value->tuberTemperatureMorning <> null) bg-danger @endif">
                                                            {{$value->tuberTemperatureMorning}}@if($value->tuberTemperatureMorning <> '')
                                                                &degС@endif</td>
                                                        <td>{{$value->humidity}}</td>
                                                        <td class="text-center @if($value->condensate) bg-danger @endif">
                                                            @if($value->condensate)
                                                                +
                                                            @endif</td>
                                                        <td>{{$value->comment}}</td>
                                                        <td style="color: #ffd300">
                                                            @forelse($value->productMonitoringControl as $text)
                                                                @if($text->level == 1)
                                                                    <label
                                                                        style="color: black">{{\App\Models\Registration::query()->where('user_id', $text->user_id)->value('last_name')}}
                                                                        :</label>   {{$text->text}}
                                                                @endif
                                                            @empty
                                                            @endforelse
                                                        </td>
                                                        <td style="color: #d00101">
                                                            @forelse($value->productMonitoringControl as $text)
                                                                @if($text->level == 2)
                                                                    <label
                                                                        style="color: black">{{\App\Models\Registration::query()->where('user_id', $text->user_id)->value('last_name')}}
                                                                        :</label>   {{$text->text}}
                                                                @endif
                                                            @empty
                                                            @endforelse
                                                        </td>
                                                    </tr>

                                                @endforeach

                                            </table>
                                        </div>
                                        @empty
                                            <p>Нет данных на:
                                                <b>{{\Illuminate\Support\Carbon::parse($date)->format('d-m-Y')}}</b></p>
                                        @endforelse
                                </div>
                    </div>
                </div>
            </div>
    @endif
@endsection('info')
