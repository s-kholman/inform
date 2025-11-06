@extends('layouts.base')
@section('title', 'Отчет - автоматический мониторинг температуры хранения продукции')
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
        <form action="{{route('monitoring.device.report.day')}}" method="POST">
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

        <table class="table table-hover table-bordered text-center">
            <tr>
                <th  rowspan="2">Бокс</th>
                <th style="background-color: #f3f9ff" colspan="3">Бурт</th>
                <th style="background-color: #c0e1e7" colspan="3">Шахта</th>
                <th colspan="3">Устройство</th>
            </tr>
            <tr>
                <th style="background-color: #f3f9ff">MAX</th>
                <th style="background-color: #f3f9ff">MIN</th>
                <th style="background-color: #f3f9ff">AVG</th>
                <th style="background-color: #c0e1e7" >MAX</th>
                <th style="background-color: #c0e1e7" >MIN</th>
                <th style="background-color: #c0e1e7" >AVG</th>
                <th>MAX</th>
                <th>MIN</th>
                <th>AVG</th>
            </tr>
            @foreach($group_monitoring as $value)
                <tr>
                    <td>{{$value->name}}</td>
                    <td style="background-color: #f3f9ff">{{$value->max_temperature_point_one}} &degС</td>
                    <td style="background-color: #f3f9ff" class="@if($value->min_temperature_point_one < 0) bg-danger @endif ">{{$value->min_temperature_point_one}} &degС</td>
                    <td style="background-color: #f3f9ff">{{$value->avg_temperature_point_one}} &degС</td>
                    <td style="background-color: #c0e1e7" >{{$value->max_temperature_point_two}} &degС</td>
                    <td style="background-color: #c0e1e7"  class="@if($value->min_temperature_point_two < 0) bg-danger @endif ">{{$value->min_temperature_point_two}} &degС</td>
                    <td style="background-color: #c0e1e7" >{{$value->avg_temperature_point_two}} &degС</td>
                    <td>{{$value->max_temperature_humidity}} &degС</td>
                    <td class="@if($value->min_temperature_humidity < 0) bg-danger @endif ">{{$value->min_temperature_humidity}} &degС</td>
                    <td>{{$value->avg_temperature_humidity}} &degС</td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection('info')
