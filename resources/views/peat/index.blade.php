@extends('layouts.base')
@section('title', 'Справочник')
<style>

    .rotate {
        writing-mode: vertical-rl;
        transform: rotate(-180deg);
        vertical-align: middle;
    }
</style>
@section('info')


    <div class="container">
        <div class="row p-5">
            <div class="col-4 text-center">
                <a class="btn btn-info" href="/peat/create">Внести данные</a>
            </div>
            @can('viewAdmin', 'App\Models\Peat')
            <div class="col-4 text-center">
                <a class="btn btn-info" href="/extraction">Внести место добычи</a>
            </div>
            <div class="col-4 text-center">
                <a class="btn btn-info" href="/pole">Поля</a>
            </div>
            @endcan
        </div>
        <div class="row">

            @forelse($harvest_all as $harvest)
            <div class="col">
               <a href="/peat/{{$harvest[0]->harvest_year_id}}">{{\Carbon\Carbon::parse('01-01-'.$harvest[0]->harvest_name)->addYear(-1)->format('Y')}} - {{$harvest[0]->harvest_name}}</a>
            </div>
            @empty
            @endforelse
        </div>
        @if(!empty($result))
            <div class="row p-2">
                <div class="col-12">

                    <table class="table table-bordered text-center caption-top table-striped">
                        <caption class="border text-center">
                            <b><p>Информация за {{\Carbon\Carbon::parse('01-01-'.$harvest_all[$harvest_year_id] [0]->harvest_name)->addYear(-1)->format('Y')}}-{{$harvest_all[$harvest_year_id] [0]->harvest_name}} год</p></b>
                        </caption>
                        <thead>
                        <tr>
                        <th rowspan="3" ><div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Дата&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></th>
                        @foreach(current($result) as $filial_id => $peat_extraction)
                            <th colspan="{{count($peat_extraction, COUNT_RECURSIVE)-count($peat_extraction)}}">{{\App\Models\filial::query()->where('id', $filial_id)->value('name')}}</th>
                        @endforeach
                        <th rowspan="3" class="rotate">Итого за сутки</th>
                        </tr>
                        <tr>
                        @foreach(current($result) as $filial_id => $peat_extraction)
                            @foreach($peat_extraction as $peat_extraction_id => $pole)
                            <th colspan="{{count($pole)}}">{{\App\Models\PeatExtraction::query()->where('id', $peat_extraction_id)->value('name')}}</th>
                                @endforeach
                        @endforeach
                        </tr>

                        <tr>
                            @foreach(current($result) as $filial_id => $peat_extraction)
                                @foreach($peat_extraction as $peat_extraction_id => $pole)
                                    @foreach($pole as $pole_id => $value)
                                        <th class="rotate">{{\App\Models\Pole::query()->where('id', $pole_id)->value('name')}}</th>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tr>

                        </thead>
                        <tbody>

                        @foreach($result as $date => $filial)
                            <tr>
                                <td name="data" class="text-center">{{\Carbon\Carbon::parse($date)->format('d-m-Y')}}</td>
                                @foreach($filial as $filial_id => $peat_extraction)
                                    @foreach($peat_extraction as $peat_extraction_id => $pole)
                                        @foreach($pole as $pole_id => $value)
                                            @if(($value->harvest_year_id ?? false) && array_key_exists($value->harvest_year_id, $harvest_show) && $harvest_show[$value->harvest_year_id])
                                                <td><a href="/peat/{{$value->id ?? 0}}/edit">{{$value->volume ?? null}}</a></td>
                                            @else
                                                <td>{{$value->volume ?? null}}</td>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endforeach
                                <td>{{$summa_arr[$date] ['summa']}}</td>
                            </tr>
                            @if($loop->last)
                        </tbody>
                        <tfoot>
                                <tr>
                                    <td>Итого на поле</td>
                                    @foreach($filial as $filial_id => $peat_extraction)
                                        @foreach($peat_extraction as $peat_extraction_id => $pole)
                                            @foreach($pole as $pole_id => $value)
                                                <td>
                                                    {{\App\Models\Peat::query()
                                                                        ->where('filial_id', $filial_id)
                                                                        ->where('peat_extraction_id', $peat_extraction_id)
                                                                        ->where('pole_id', $pole_id)
                                                                        ->where('harvest_year_id', $harvest_year_id)
                                                                        ->sum('volume')}}
                                                </td>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                    <td>
                                        {{\App\Models\Peat::query()
                                                            ->where('harvest_year_id', $harvest_year_id)
                                                            ->sum('volume')}}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tfoot>
                    </table>
                </div>

            </div>



            @else
            <div class="row p-4">
                <div class="col">
                    <p>Нет данных на текущий период. Выберите за предыдущий год или внесите новые данные</p>
                </div>
            </div>
        @endif


    </div>

@endsection('info')
