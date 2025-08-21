@extends('layouts.base')
@section('title', 'Мониторинг температуры c устройства - ТЕСТИРОВАНИЕ')
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
        <div class="row">
            <table class="table table-bordered text-center">
                <tr>
                    <th class="vertical-align" rowspan="2"><label class="rotate">Дата</label></th>
                    @if($group_monitoring->where('avg_temperature_point_one', '>', 0)->count() > 0)
                    <th class="vertical-align" colspan="3"><label >Точка замера №1</label></th>
                    @endif
                    @if($group_monitoring->where('avg_temperature_point_two', '>', 0)->count() > 0)
                    <th class="vertical-align" colspan="3"><label >Точка замера №2</label></th>
                    @endif
                    @if($group_monitoring->where('avg_temperature_point_three', '>', 0)->count() > 0)
                    <th class="vertical-align" colspan="3"><label >Точка замера №3</label></th>
                    @endif
                    @if($group_monitoring->where('avg_temperature_point_four', '>', 0)->count() > 0)
                        <th class="vertical-align" colspan="3"><label >Точка замера №4</label></th>
                    @endif
                    @if($group_monitoring->where('avg_temperature_point_five', '>', 0)->count() > 0)
                        <th class="vertical-align" colspan="3"><label >Точка замера №5</label></th>
                    @endif
                    @if($group_monitoring->where('avg_temperature_point_six', '>', 0)->count() > 0)
                        <th class="vertical-align" colspan="3"><label >Точка замера №6</label></th>
                    @endif
                </tr>
                <tr>
                        @if($group_monitoring->where('avg_temperature_point_one', '>', 0)->count() > 0)
                            <td>MAX</td>
                            <td>MIN</td>
                            <td>AVG</td>
                        @endif
                        @if($group_monitoring->where('avg_temperature_point_two', '>', 0)->count() > 0)
                            <td>MAX</td>
                            <td>MIN</td>
                            <td>AVG</td>
                        @endif
                        @if($group_monitoring->where('avg_temperature_point_three', '>', 0)->count() > 0)
                            <td>MAX</td>
                            <td>MIN</td>
                            <td>AVG</td>
                        @endif
                            @if($group_monitoring->where('avg_temperature_point_four', '>', 0)->count() > 0)
                                <td>MAX</td>
                                <td>MIN</td>
                                <td>AVG</td>
                            @endif
                            @if($group_monitoring->where('avg_temperature_point_five', '>', 0)->count() > 0)
                                <td>MAX</td>
                                <td>MIN</td>
                                <td>AVG</td>
                            @endif
                            @if($group_monitoring->where('avg_temperature_point_six', '>', 0)->count() > 0)
                                <td>MAX</td>
                                <td>MIN</td>
                                <td>AVG</td>
                            @endif
                </tr>
                @foreach($group_monitoring as $value)
                    <tr>
                        <td>{{$value->date}}</td>
                        @if($group_monitoring->where('avg_temperature_point_one', '>', 0)->count() > 0)
                        <td>{{round($value->max_temperature_point_one, 1)}}</td>
                        <td>{{round($value->min_temperature_point_one, 1)}}</td>
                        <td>{{round($value->avg_temperature_point_one, 1)}}</td>
                        @endif
                        @if($group_monitoring->where('avg_temperature_point_two', '>', 0)->count() > 0)
                        <td>{{round($value->max_temperature_point_two, 1)}}</td>
                        <td>{{round($value->min_temperature_point_two, 1)}}</td>
                        <td>{{round($value->avg_temperature_point_two, 1)}}</td>
                        @endif
                        @if($group_monitoring->where('avg_temperature_point_three', '>', 0)->count() > 0)
                        <td>{{round($value->max_temperature_point_three, 1)}}</td>
                        <td>{{round($value->min_temperature_point_three, 1)}}</td>
                        <td>{{round($value->avg_temperature_point_three, 1)}}</td>
                        @endif
                        @if($group_monitoring->where('avg_temperature_point_four', '>', 0)->count() > 0)
                            <td>{{round($value->max_temperature_point_three, 1)}}</td>
                            <td>{{round($value->min_temperature_point_three, 1)}}</td>
                            <td>{{round($value->avg_temperature_point_three, 1)}}</td>
                        @endif
                        @if($group_monitoring->where('avg_temperature_point_five', '>', 0)->count() > 0)
                            <td>{{round($value->max_temperature_point_five, 1)}}</td>
                            <td>{{round($value->min_temperature_point_five, 1)}}</td>
                            <td>{{round($value->avg_temperature_point_five, 1)}}</td>
                        @endif
                        @if($group_monitoring->where('avg_temperature_point_six', '>', 0)->count() > 0)
                            <td>{{round($value->max_temperature_point_five, 1)}}</td>
                            <td>{{round($value->min_temperature_point_five, 1)}}</td>
                            <td>{{round($value->avg_temperature_point_five, 1)}}</td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>

        <table class="table table-bordered text-center">
            <tr>
                <th class="vertical-align"><label class="rotate">Дата</label></th>
                <th class="vertical-align"><label class="rotate">Точка замера №1</label></th>
                <th class="vertical-align"><label class="rotate">Точка замера №2</label></th>
                <th class="vertical-align"><label class="rotate">Точка замера №3</label></th>
                <th class="vertical-align"><label class="rotate">Точка замера №4</label></th>
                <th class="vertical-align"><label class="rotate">Точка замера №5</label></th>
                <th class="vertical-align"><label class="rotate">Точка замера №6</label></th>
                <th class="vertical-align"><label class="rotate">ID устройства</label></th>
                <th class="vertical-align"><label class="rotate">ADC</label></td>
                <th class="vertical-align"><label class="rotate">RSSI</label></th>
                <th class="vertical-align"><label class="rotate">Version</label></td>
            </tr>

            @foreach($monitoring as $id => $value)
                <tr>
                    <td>{{$value->created_at}}</td>
                    <td>{{round($value->temperature_point_one, 1)}}</td>
                    <td>{{round($value->temperature_point_two, 1)}}</td>
                    <td>{{round($value->temperature_point_three, 1)}}</td>
                    <td>{{round($value->temperature_point_four, 1)}}</td>
                    <td>{{round($value->temperature_point_five, 1)}}</td>
                    <td>{{round($value->temperature_point_six, 1)}}</td>
                    <td>{{$value->device_e_s_p_id}}</td>
                    <td>{{round(4.2/812*$value->adc, 3)}}v</td>
                    <td>{{$value->rssi}}</td>
                    <td>{{$value->version}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection('info')

