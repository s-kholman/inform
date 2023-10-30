@extends('layouts.base')
@section('title', 'Отчет о температуре хранения продукции в боксах')

@section('info')

    <div class="container px-5">
        <div class="row row-cols-2 gy-5">

            <div class="col-12">
                <a class="btn btn-info" href="/monitoring/reports/">Назад</a>
            </div>


            <div class="col-12">
                @forelse($arr_value as $filial_id => $item)
                    @if ($loop->first)
                        <table class="table table-bordered">
                            @endif
                            <tr>
                                <td colspan="9"><b>{{\App\Models\filial::where('id', $filial_id)->value('name')}} на
                                        {{\Illuminate\Support\Carbon::parse($date)->format('d-m-Y')}}</b>
                                </td>
                            </tr>
                            <tr>
                                <td>Бокс</td>
                                <td>t °С Бурта в трубах</td>
                                <td>t °С над буртом</td>
                                <td>t °С клубня утром</td>
                                <td>t °С клубня вечером</td>
                                <td>Влажность</td>
                                <td>Фаза хранения</td>
                                <td>Режим</td>
                                <td>Комментарий</td>
                            </tr>

                            @foreach($item as $value)
                                <tr>
                                    <td>{{$value->storageName->name}}</td>
                                    <td>{{$value->burtTemperature}}</td>
                                    <td>{{$value->burtAboveTemperature}}</td>
                                    <td>{{$value->tuberTemperatureMorning}}</td>
                                    <td>{{$value->tuberTemperatureEvening}}</td>
                                    <td>{{$value->humidity}}</td>
                                    <td>{{$value->phase->name}}</td>
                                    <td class="text-nowrap">
                                        @forelse($value->Mode as $mode)
                                            {{\Carbon\Carbon::parse($mode->timeUp)->format('H:i')}} - {{\Carbon\Carbon::parse($mode->timeDown)->format('H:i')}}; <br>
                                        @empty
                                            н/д
                                        @endforelse
                                    </td>
                                    <td>{{$value->comment}}</td>
                                </tr>
                            @endforeach

                            @if($loop->last)
                        </table>
                    @endif
                @empty
                    <p>Нет данных на: <b>{{\Illuminate\Support\Carbon::parse($date)->format('d-m-Y')}}</b></p>
                @endforelse
            </div>
        </div>
    </div>










@endsection('info')
