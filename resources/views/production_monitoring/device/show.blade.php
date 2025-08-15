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
                    <td>{{round($value->temperaturePointOne, 1)}}</td>
                    <td>{{round($value->temperaturePointTwo, 1)}}</td>
                    <td>{{round($value->temperaturePointThree, 1)}}</td>
                    <td>{{round($value->temperaturePointFour, 1)}}</td>
                    <td>{{round($value->temperaturePointFive, 1)}}</td>
                    <td>{{round($value->temperaturePointSix, 1)}}</td>
                    <td>{{$value->device_e_s_p_id}}</td>
                    <td>{{round(4.2/812*$value->ADC, 3)}}v</td>
                    <td>{{$value->RSSI}}</td>
                    <td>{{$value->version}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection('info')

