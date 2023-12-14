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
                <a class="btn btn-info" href="/sowing/create">Внести данные</a>
            </div>
        </div>
        <div class="row">

            @forelse($harvest_all as $harvest)
                <div class="col">
                    <a href="/sowing?type={{$sowing_type_id}}&harvest={{$harvest[0]->harvest_year_id}}">{{$harvest[0]->harvest_name}}</a>
                </div>
            @empty
            @endforelse
        </div>
        @if(!empty($result))
            <div class="row p-2">
                <div class="col-12">

                    <table class="table table-bordered text-center caption-top table-striped">

                        <thead>
                        <tr>
                            <th rowspan="3" ><div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Дата&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></th>
                            @foreach(current($result) as $filial_id => $key)
                                <th colspan="{{\App\Models\Sowing::query()
                                                                ->where('sowing_type_id', $sowing_type_id)
                                                                ->where('filial_id', $filial_id)
                                                                ->where('harvest_year_id', $harvest_year_id)
                                                                ->get()
                                                                ->unique('sowing_last_name_id')
                                                                ->count()}}">
                                    {{\App\Models\filial::query()->where('id', $filial_id)->value('name')}}</th>
                            @endforeach
                            <th rowspan="3" class="rotate">Итого за сутки</th>
                        </tr>
                        <tr>
                            @foreach(current($result) as $filial_id => $machine)
                                @foreach($machine as $machine_id => $sowing_last_name)

                                    <th colspan="{{count($sowing_last_name)}}">{{\App\Models\Machine::query()->where('id', $machine_id)->value('name')}}</th>
                                @endforeach
                            @endforeach
                        </tr>

                        <tr>
                            @foreach(current($result) as $filial_id => $machine)
                                @foreach($machine as $machine_id => $sowing_last_name)
                                    @foreach($sowing_last_name as $sowing_last_name_id => $value)
                                        <th class="rotate">{{\App\Models\SowingLastName::query()->where('id', $sowing_last_name_id)->value('name')}}</th>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tr>

                        </thead>
                        <tbody>

                        @foreach($result as $date => $filial)
                            <tr>
                                <td name="data" class="text-center">{{\Carbon\Carbon::parse($date)->format('d-m-Y')}}</td>
                                @foreach($filial as $filial_id => $agregat)
                                    @foreach($agregat as $agregat_id => $fio)
                                        @foreach($fio as $fio_id => $value)
                                            @if (array_key_exists('default', $value))
                                                <td></td>
                                            @else
                                                @foreach($value as $kultura_id => $model)

                                                    @if (count($value) > 1)
                                                        @if ($loop->first)
                                                            <td>
                                                            <table> <tbody><tr>
                                                        @endif
                                                        <td class="text-center">{{ $model->volume }}</td>

                                                        @if ($loop->last)
                                                           </tr></tbody></table></td>
                                                        @endif
                                                    @else
                                                        <td>{{$model->volume}}</td>
                                                    @endif

                                                @endforeach
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
