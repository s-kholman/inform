@extends('layouts.base')
@section('title', 'Мониторинг температуры автоматической фиксации')
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
        <div class="row mb-2">
            <div class="col-4">
               <a class="btn btn-secondary " href="{{route('product.monitoring.devices.show.storage', ['id' => $monitoring[0]->storage_name_id, 'year' => $monitoring[0]->harvest_year_id])}}">Назад</a>
            </div>
        </div>
        <table class="table table-bordered text-center caption-top">
            <caption><b>{{\App\Models\StorageName::query()->where('id', $storage_name_id)->first('name')['name']}}</b><br></caption>
            <tr>
                <th class="vertical-align"><label class="rotate">Дата</label></th>

                @if($monitoring->where('temperature_point_one', '<>', null)->groupBy('temperature_point_one')->count() > 0)
                    <th class="vertical-align" ><label >Температура в бурте</label></th>
                @endif
                @if($monitoring->where('temperature_point_two', '<>', null)->groupBy('temperature_point_two')->count() > 0)
                        <th class="vertical-align" ><label >Температура в шахте</label></th>
                @endif
                @if($monitoring->where('temperature_point_three', '<>', null)->groupBy('temperature_point_three')->count() > 0)
                        <th class="vertical-align" ><label >Точка замера устройство</label></th>
                @endif
                @if($monitoring->where('temperature_point_four', '<>', null)->groupBy('temperature_point_four')->count() > 0)
                        <th class="vertical-align" ><label >Точка замера №4</label></th>
                @endif
                @if($monitoring->where('temperature_point_five', '<>', null)->groupBy('temperature_point_five')->count() > 0)
                        <th class="vertical-align" ><label >Точка замера №5</label></th>
                @endif
                @if($monitoring->where('temperature_point_six', '<>', null)->groupBy('temperature_point_six')->count() > 0)
                        <th class="vertical-align" ><label >Точка замера №6</label></th>
                @endif
                @if($monitoring->where('temperature_point_seven', '<>', null)->groupBy('temperature_point_seven')->count() > 0)
                        <th class="vertical-align" ><label >Точка замера №7</label></th>
                @endif
                @if($monitoring->where('temperature_point_eight', '<>', null)->groupBy('temperature_point_eight')->count() > 0)
                        <th class="vertical-align" ><label >Точка замера №8</label></th>
                @endif
                @if($monitoring->where('temperature_point_nine', '<>', null)->groupBy('temperature_point_nine')->count() > 0)
                        <th class="vertical-align" ><label >Точка замера №9</label></th>
                @endif
                @if($monitoring->where('temperature_point_ten', '<>', null)->groupBy('temperature_point_ten')->count() > 0)
                        <th class="vertical-align" ><label >Точка замера №10</label></th>
                @endif
                @if($monitoring->where('temperature_point_eleven', '<>', null)->groupBy('temperature_point_eleven')->count() > 0)
                        <th class="vertical-align" ><label >Точка замера №11</label></th>
                @endif
                @if($monitoring->where('temperature_point_twelve', '<>', null)->groupBy('temperature_point_twelve')->count() > 0)
                        <th class="vertical-align" ><label >Точка замера №12</label></th>
                @endif
                <th class="vertical-align"><label class="rotate">Влажность</label></th>
                <th class="vertical-align"><label class="rotate">Точка замера устройство</label></th>
                @can('DeviceESP.user.view')
                <th class="vertical-align"><label class="rotate">ID устройства</label></th>
                <th class="vertical-align"><label class="rotate">ADC</label></td>
                <th class="vertical-align"><label class="rotate">RSSI</label></th>
                <th class="vertical-align"><label class="rotate">Version</label></td>
                <th class="vertical-align"><label class="rotate">Удалить</label></td>
                @endcan
            </tr>
            @foreach($monitoring as $id => $value)
                <tr>
                    {{--product.monitoring.devices.show.storage.day--}}
                    <td>{{\Illuminate\Support\Carbon::parse($value->created_at)->format('d.m.Y H:i')}}</td>
                    @if($monitoring->where('temperature_point_one', '<>', null)->groupBy('temperature_point_one')->count() > 0)
                        <td>{{round($value->temperature_point_one, 1)}}</td>
                    @endif
                    @if($monitoring->where('temperature_point_two', '<>', null)->groupBy('temperature_point_two')->count() > 0)
                        <td>{{round($value->temperature_point_two, 1)}}</td>
                    @endif
                    @if($monitoring->where('temperature_point_three', '<>', null)->groupBy('temperature_point_three')->count() > 0)
                        <td>{{round($value->temperature_point_three, 1)}}</td>
                    @endif
                    @if($monitoring->where('temperature_point_four', '<>', null)->groupBy('temperature_point_four')->count() > 0)
                        <td>{{round($value->temperature_point_four, 1)}}</td>
                    @endif
                    @if($monitoring->where('temperature_point_five', '<>', null)->groupBy('temperature_point_five')->count() > 0)
                        <td>{{round($value->temperature_point_five, 1)}}</td>
                    @endif
                    @if($monitoring->where('temperature_point_six', '<>', null)->groupBy('temperature_point_six')->count() > 0)
                        <td>{{round($value->temperature_point_six, 1)}}</td>
                    @endif
                    @if($monitoring->where('temperature_point_seven', '<>', null)->groupBy('temperature_point_seven')->count() > 0)
                        <td>{{round($value->temperature_point_seven, 1)}}</td>
                    @endif
                    @if($monitoring->where('temperature_point_eight', '<>', null)->groupBy('temperature_point_eight')->count() > 0)
                        <td>{{round($value->temperature_point_eight, 1)}}</td>
                    @endif
                    @if($monitoring->where('temperature_point_nine', '<>', null)->groupBy('temperature_point_nine')->count() > 0)
                        <td>{{round($value->temperature_point_nine, 1)}}</td>
                    @endif
                    @if($monitoring->where('temperature_point_ten', '<>', null)->groupBy('temperature_point_ten')->count() > 0)
                        <td>{{round($value->temperature_point_ten, 1)}}</td>
                    @endif
                    @if($monitoring->where('temperature_point_eleven', '<>', null)->groupBy('temperature_point_eleven')->count() > 0)
                        <td>{{round($value->temperature_point_eleven, 1)}}</td>
                    @endif
                    @if($monitoring->where('temperature_point_twelve', '<>', null)->groupBy('temperature_point_twelve')->count() > 0)
                        <td>{{round($value->temperature_point_twelve, 1)}}</td>
                    @endif
                    <td>{{round($value->humidity, 2)}}</td>
                    <td>{{round($value->temperature_humidity, 2)}}</td>
                    @can('DeviceESP.user.view')
                    <td>{{$value->device_e_s_p_id}}</td>
                    <td>{{$value->adc}}@if(!empty($value->adc))v @endif</td>
                    <td>{{$value->rssi}}</td>
                    <td>{{$value->version}}</td>
                        <td>
                            <form action="{{ route('product.monitoring.devices.destroy', ['productMonitoringDevice' => $value->id])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-danger" value="Удалить">
                            </form>
                        </td>
                    @endcan
                </tr>
            @endforeach
        </table>
    </div>
@endsection('info')

