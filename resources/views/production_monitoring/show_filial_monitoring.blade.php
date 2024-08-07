@extends('layouts.base')
@section('title', 'Мониторинг температуры в боксах')

@section('info')
    <div class="container">

        <div class="row mb-3">
            <div class="col-5">
                <h4>{{$monitoring[0]->storageName->name}}</h4>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-3 ">
                <a class="btn btn-info" href="/monitoring/create">Внести данные</a>
            </div>
            <div class="col-4">

            </div>
            <div class="col-3">
                <a class="btn btn-secondary" href="{{route('monitoring.show.filial', ['filial_id' => $monitoring[0]->storageName->filial_id, 'harvest_year_id' => $monitoring[0]->harvest_year_id])}}">Назад</a>
            </div>
        </div>

        <div class="row text-center">
            <div class="text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">Дата</div>
            <div class="text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">t &degС <br> Бурта в трубах</div>
            <div class="text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">t &degС <br> над буртом</div>
            <div class="text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">t &degС <br> клубня утром</div>
            <div class="text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">t &degС <br> клубня вечером</div>
            <div class="text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">Влажность</div>
            <div class="text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">Фазы</div>
            <div class="text-break col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">Режим</div>
            <div class="text-break col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 border border-2">Конденсат</div>
            <div class="text-break col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 border border-2">Коментарий</div>
        </div>
        @foreach($monitoring as $id => $value)
            <div class="row text-center">
                <div class="col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">
                    <a href="/monitoring/{{$value->id}}/edit">{{\Carbon\Carbon::parse($value->date)->format('d-m-Y')}}</a>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$value->burtTemperature}}&degС</div>
                <div class="col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$value->burtAboveTemperature}}&degС</div>
                <div class="col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$value->tuberTemperatureMorning}}&degС</div>
                <div class="col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2
@if(($value->tuberTemperatureEvening < 3.5 || $value->tuberTemperatureEvening > 4.5) && $value->tuberTemperatureEvening <> null) bg-danger @endif">
                    {{$value->tuberTemperatureEvening}}&degС
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$value->humidity}}</div>
                <div class="text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2">{{$value->phase->name}}</div>

                <div class="text-break col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 col-xxl-1 ">
                    @forelse(\App\Models\StorageMode::where('product_monitoring_id', $value->id)->orderby('timeUp')->get() as $mode)
                        <div class="row">
                            <div class="col-12 border border-1">
                                <a href="/monitoring/mode/show/{{$mode->id}}">{{\Carbon\Carbon::parse($mode->timeUp)->format('H:i')}} {{\Carbon\Carbon::parse($mode->timeDown)->format('H:i')}}</a> <br>
                            </div>
                        </div>
                    @empty
                        <div class="row border border-1">
                            <div class="col-12 border border-1">
                                н/д
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="text-break col-xs-1 col-sm-1 col-md-1col-lg-1 col-xl-1 col-xxl-1 border border-2 @if($value->condensate) bg-danger @endif">
                    @if($value->condensate)
                        +
                    @endif

                </div>
                <div class="text-break col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 border border-2">{{$value->comment}}</div>
            </div>
        @endforeach
        <div class="row p-4">
            {{$monitoring->links()}}
        </div>
    </div>
@endsection('info')

