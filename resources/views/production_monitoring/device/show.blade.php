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

</style>
@section('info')
    <div class="container">
        <div> {!! $chart1->renderHtml() !!}</div>

        <div class="row">
            <div class="col-4">
                {{--<a class="btn btn-secondary " href="{{route('monitoring.show.filial.all', ['storage_name_id' => $storage_name_id, 'harvest_year_id' => $year_id])}}">Назад</a>--}}
                <a class="btn btn-secondary " href="{{route('monitoring.show.filial', ['filial_id' => $filial_id, 'harvest_year_id' => $year_id])}}">Назад</a>
            </div>
            @canany(['ProductMonitoring.director.create', 'ProductMonitoring.completed.create'])
                <div class="col-sm-4 ">
                    <a class="btn btn-info" href="/monitoring/create">Внести данные</a>
                </div>
            @endcanany
            <div class="mt-2">
                <table class="table table-bordered text-center caption-top">
                    <caption class="text-center"><b>{{\App\Models\StorageName::query()->where('id', $storage_name_id)->first('name')['name']}}</b><br>Максимальная/Минимальная/Средняя температура в разрезе суток по точкам измерения. Для подробного представления нажмите на соответствующею дату</caption>
                    <tr>
                        <th class="vertical-align" rowspan="2"><label class="rotate">Дата</label></th>
                        @if($group_monitoring->where('avg_temperature_point_one', '>', 0)->count() > 0)
                            <th class="vertical-align" colspan="3"><label >Температура в бурте</label></th>
                        @endif
                        @if($group_monitoring->where('avg_temperature_point_two', '>', 0)->count() > 0)
                            <th class="vertical-align" colspan="3"><label >Температура в шахте</label></th>
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

                        @if($group_monitoring->where('avg_temperature_point_seven', '>', 0)->count() > 0)
                            <th class="vertical-align" colspan="3"><label >Точка замера №7</label></th>
                        @endif
                        @if($group_monitoring->where('avg_temperature_point_eight', '>', 0)->count() > 0)
                            <th class="vertical-align" colspan="3"><label >Точка замера №8</label></th>
                        @endif
                        @if($group_monitoring->where('avg_temperature_point_nine', '>', 0)->count() > 0)
                            <th class="vertical-align" colspan="3"><label >Точка замера №9</label></th>
                        @endif
                        @if($group_monitoring->where('avg_temperature_point_ten', '>', 0)->count() > 0)
                            <th class="vertical-align" colspan="3"><label >Точка замера №10</label></th>
                        @endif
                        @if($group_monitoring->where('avg_temperature_point_eleven', '>', 0)->count() > 0)
                            <th class="vertical-align" colspan="3"><label >Точка замера №11</label></th>
                        @endif
                        @if($group_monitoring->where('avg_temperature_point_twelve', '>', 0)->count() > 0)
                            <th class="vertical-align" colspan="3"><label >Точка замера №12</label></th>
                        @endif
                        @if($group_monitoring->where('avg_temperature_humidity', '>', 0)->count() > 0)
                            <th class="vertical-align" colspan="3"><label >Точка замера устройство</label></th>
                        @endif
                        @if($group_monitoring->where('avg_humidity', '>', 0)->count() > 0)
                            <th class="vertical-align" colspan="3"><label >Влажность</label></th>
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

                            @if($group_monitoring->where('avg_temperature_point_seven', '>', 0)->count() > 0)
                                <td>MAX</td>
                                <td>MIN</td>
                                <td>AVG</td>
                            @endif

                            @if($group_monitoring->where('avg_temperature_point_eight', '>', 0)->count() > 0)
                                <td>MAX</td>
                                <td>MIN</td>
                                <td>AVG</td>
                            @endif

                            @if($group_monitoring->where('avg_temperature_point_nine', '>', 0)->count() > 0)
                                <td>MAX</td>
                                <td>MIN</td>
                                <td>AVG</td>
                            @endif

                            @if($group_monitoring->where('avg_temperature_point_ten', '>', 0)->count() > 0)
                                <td>MAX</td>
                                <td>MIN</td>
                                <td>AVG</td>
                            @endif

                            @if($group_monitoring->where('avg_temperature_point_eleven', '>', 0)->count() > 0)
                                <td>MAX</td>
                                <td>MIN</td>
                                <td>AVG</td>
                            @endif

                            @if($group_monitoring->where('avg_temperature_point_twelve', '>', 0)->count() > 0)
                                <td>MAX</td>
                                <td>MIN</td>
                                <td>AVG</td>
                            @endif
                            @if($group_monitoring->where('avg_temperature_humidity', '>', 0)->count() > 0)
                                <td>MAX</td>
                                <td>MIN</td>
                                <td>AVG</td>
                            @endif
                            @if($group_monitoring->where('avg_humidity', '>', 0)->count() > 0)
                                <td>MAX</td>
                                <td>MIN</td>
                                <td>AVG</td>
                            @endif
                    </tr>

                    @foreach($group_monitoring as $value)
                        <tr>
                            <td><a href="{{route('product.monitoring.devices.show.storage.day', ['id' => $storage_name_id, 'year' => $year_id, 'day' => $value->date])}}">{{\Illuminate\Support\Carbon::parse($value->date)->format('d.m.Y')}}</a></td>
                            {{--<td>{{$value->date}}</td>--}}
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
                                <td>{{round($value->max_temperature_point_four, 1)}}</td>
                                <td>{{round($value->min_temperature_point_four, 1)}}</td>
                                <td>{{round($value->avg_temperature_point_four, 1)}}</td>
                            @endif
                            @if($group_monitoring->where('avg_temperature_point_five', '>', 0)->count() > 0)
                                <td>{{round($value->max_temperature_point_five, 1)}}</td>
                                <td>{{round($value->min_temperature_point_five, 1)}}</td>
                                <td>{{round($value->avg_temperature_point_five, 1)}}</td>
                            @endif
                            @if($group_monitoring->where('avg_temperature_point_six', '>', 0)->count() > 0)
                                <td>{{round($value->max_temperature_point_six, 1)}}</td>
                                <td>{{round($value->min_temperature_point_six, 1)}}</td>
                                <td>{{round($value->avg_temperature_point_six, 1)}}</td>
                            @endif

                            @if($group_monitoring->where('avg_temperature_point_seven', '>', 0)->count() > 0)
                                <td>{{round($value->max_temperature_point_seven, 1)}}</td>
                                <td>{{round($value->min_temperature_point_seven, 1)}}</td>
                                <td>{{round($value->avg_temperature_point_seven, 1)}}</td>
                            @endif
                            @if($group_monitoring->where('avg_temperature_point_eight', '>', 0)->count() > 0)
                                <td>{{round($value->max_temperature_point_eight, 1)}}</td>
                                <td>{{round($value->min_temperature_point_eight, 1)}}</td>
                                <td>{{round($value->avg_temperature_point_eight, 1)}}</td>
                            @endif
                            @if($group_monitoring->where('avg_temperature_point_nine', '>', 0)->count() > 0)
                                <td>{{round($value->max_temperature_point_nine, 1)}}</td>
                                <td>{{round($value->min_temperature_point_nine, 1)}}</td>
                                <td>{{round($value->avg_temperature_point_nine, 1)}}</td>
                            @endif
                            @if($group_monitoring->where('avg_temperature_point_ten', '>', 0)->count() > 0)
                                <td>{{round($value->max_temperature_point_ten, 1)}}</td>
                                <td>{{round($value->min_temperature_point_ten, 1)}}</td>
                                <td>{{round($value->avg_temperature_point_ten, 1)}}</td>
                            @endif
                            @if($group_monitoring->where('avg_temperature_point_eleven', '>', 0)->count() > 0)
                                <td>{{round($value->max_temperature_point_eleven, 1)}}</td>
                                <td>{{round($value->min_temperature_point_eleven, 1)}}</td>
                                <td>{{round($value->avg_temperature_point_eleven, 1)}}</td>
                            @endif
                            @if($group_monitoring->where('avg_temperature_point_twelve', '>', 0)->count() > 0)
                                <td>{{round($value->max_temperature_point_twelve, 1)}}</td>
                                <td>{{round($value->min_temperature_point_twelve, 1)}}</td>
                                <td>{{round($value->avg_temperature_point_twelve, 1)}}</td>
                            @endif
                            @if($group_monitoring->where('avg_temperature_humidity', '>', 0)->count() > 0)
                                <td>{{round($value->max_temperature_humidity, 1)}}</td>
                                <td>{{round($value->min_temperature_humidity, 1)}}</td>
                                <td>{{round($value->avg_temperature_humidity, 1)}}</td>
                            @endif
                            @if($group_monitoring->where('avg_humidity', '>', 0)->count() > 0)
                                <td>{{round($value->max_humidity, 1)}}</td>
                                <td>{{round($value->min_humidity, 1)}}</td>
                                <td>{{round($value->avg_humidity, 1)}}</td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>

        </div>
    </div>
@endsection('info')

@section('script')
    {!! $chart1->renderChartJsLibrary() !!}
    {!! $chart1->renderJs() !!}
@endsection
