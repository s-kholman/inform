@extends('layouts.base')
@section('title', 'Мониторинг температуры в боксах')
<style>
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
            @can('viewButton', 'App\Models\ProductMonitoring')
            <div class="col-4 ">
                <a class="btn btn-info" href="/monitoring/create">Внести данные</a>
            </div>
            @endcan
            <div class="col-4">
                <a class="btn btn-secondary" href="{{route('monitoring.show.filial', ['filial_id' => $monitoring[0]->storageName->filial_id, 'harvest_year_id' => $monitoring[0]->harvest_year_id])}}">Назад</a>
            </div>
            @if($post_name == '"DIRECTOR"' || $post_name == '"DEPUTY"')
            <div class="col-4">
                <a class="btn btn-outline-primary" href="{{route('monitoring.control.storage', ['storage_id' => $monitoring[0]->storage_name_id, 'harvest_year_id' => $monitoring[0]->harvest_year_id])}}">Контроль</a>
            </div>
            @endif
        </div>

        <div class="row text-center">
            <div class="text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">Дата</div>
            <div class="background-color-director text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">Фазы хранения</div>
            <div class="background-color-director text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">Режим работы вентиляции</div>
            <div class="background-color-director text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">Температура хранения</div>
            <div class="background-color-director text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">Влажность хранения</div>
            <div class="text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">Температура клубня</div>
            <div class="text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">Влажность в боксе</div>
            <div class="text-break col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">Конденсат</div>
            <div class="text-break col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">Комментарий</div>
            <div class="text-break col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">Контроль руководителя</div>
            <div class="text-break col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">Контроль зам.ген.дир.</div>

        </div>
        @foreach($monitoring as $id => $value)
            <div class="row text-center">
                <div class="col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">
                    @if($post_name == '"DIRECTOR"' || $post_name == '"DEPUTY"')
                        <a href="/monitoring/{{$value->id}}/edit">{{\Carbon\Carbon::parse($value->date)->format('d-m-Y')}}</a>
                    @else
                        {{\Carbon\Carbon::parse($value->date)->format('d-m-Y')}}
                    @endif
                </div>
                <div class="background-color-director text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$value->phase->name ?? ''}}</div>
                @if($post_name == '"DIRECTOR"')
                <div class="background-color-director text-break col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-1">
                    @forelse(\App\Models\StorageMode::where('product_monitoring_id', $value->id)->orderby('timeUp')->get() as $mode)
                        <div class="row">
                            <div class="background-color-director col-12 border border-1" style="margin: 1px; padding: 1px">
                                <a href="/monitoring/mode/show/{{$mode->id}}">{{\Carbon\Carbon::parse($mode->timeUp)->format('H:i')}} {{\Carbon\Carbon::parse($mode->timeDown)->format('H:i')}}</a> <br>
                            </div>
                        </div>
                    @empty
                        <div class="row border border-1">

                        </div>
                    @endforelse
                @else
                    <div class="background-color-director text-break col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-1">
                        @forelse(\App\Models\StorageMode::where('product_monitoring_id', $value->id)->orderby('timeUp')->get() as $mode)
                            <div class="row">
                                <div class="col-12 border border-1" style="margin: 1px; padding: 1px">
                                    {{\Carbon\Carbon::parse($mode->timeUp)->format('H:i')}} {{\Carbon\Carbon::parse($mode->timeDown)->format('H:i')}}<br>
                                </div>
                            </div>
                        @empty
                            <div class="row border border-1">

                            </div>
                        @endforelse
                @endif
                </div>
                <div class="background-color-director col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$value->temperature_keeping}} @if($value->temperature_keeping <> null)&degС @endif</div>
                <div class="background-color-director col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$value->humidity_keeping}}</div>



                <div class="col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2

                     @if($value->phase->StoragePhaseTemperature->temperature_min ?? false)
                @if(
                       ($value->tuberTemperatureMorning < $value->phase->StoragePhaseTemperature->temperature_min ||
                        $value->tuberTemperatureMorning > $value->phase->StoragePhaseTemperature->temperature_max) &&
                        $value->tuberTemperatureMorning <> null)
                bg-danger @endif
                    @endif">

                    {{$value->tuberTemperatureMorning}}
                    @if($value->tuberTemperatureMorning <> null)&degС @endif</div>
                <div class="col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$value->humidity}}</div>
                <div class="text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2 @if($value->condensate) bg-danger @endif">
                    @if($value->condensate)
                        +
                    @endif
                </div>
                <div class="text-break col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$value->comment}}</div>
                            <div style="color: #ffd300" class="text-break col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">
                            @forelse($value->productMonitoringControl as $text)
                                @if($text->level == 1)
                                        <label style="color: black">{{\App\Models\Registration::query()->where('user_id', $text->user_id)->value('last_name')}}:</label>   {{$text->text}}
                                @endif
                            @empty
                            @endforelse
                            </div>
                <div style="color: #d00101" class="text-break col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">
                    @forelse($value->productMonitoringControl as $text)
                        @if($text->level == 2)
                            <label style="color: black">{{\App\Models\Registration::query()->where('user_id', $text->user_id)->value('last_name')}}:</label>   {{$text->text}}
                        @endif
                    @empty
                    @endforelse
                </div>



            </div>
        @endforeach
        <div class="row p-4">
            {{$monitoring->links()}}
        </div>
    </div>
@endsection('info')

