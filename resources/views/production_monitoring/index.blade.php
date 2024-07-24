@extends('layouts.base')
@section('title', 'Мониторинг температуры в боксах')

@section('info')
    <div class="container">
        <div class="row  text-center">
            <div class="col-12 p-">
                <p><h4>Отчет о температуре хранения продукции в боксах:</h4></p>
            </div>
        </div>
        <div class="row  text-center border border-1">
            <div class="col-12 ">
                <p><h4>Года хранения:</h4></p>
            </div>
            <div class="row text-center p-5">

                    @forelse($year as $name => $value)
                    <div class="col-3">
                      <a href="/monitoring/index/{{$value[0]->harvestYear->id}}">{{\Carbon\Carbon::parse('01-01-'.$name)->addYear(-1)->format('Y')}} - {{$name}}</a>
                    </div>
                    @empty
                    @endforelse

            </div>
        </div>

        @forelse($filial as $filal_name => $value)

            @if ($loop->first)
                <div class="row text-center">
                    <div class="col-4 p-6"></div><div class="text-center"><h5>Филиалы:</h5></div>
                </div>
                <div class="row text-center p-5">
            @endif
                    <div class="col-12"><h4><p><a href="{{route('monitoring.show.filial', ['filial_id' => $value[0]->Storagefilial->nameFilial->id, 'harvest_year_id'=> $value[0]->harvest_year_id])}}">{{$filal_name}}</a></p></h4></div>
            @if($loop->last)
                </div>
                @endif
        @empty
            <div class="row">
                <div class="col-12 p-5 text-center">
                    <p><h4>Нет данных для отображения. Воспользуйтесь кнопкой "Внести данные"</h4></p>
                </div>
            </div>
        @endforelse

            <div class="row ">
                <div class="col-12 text-center">
                    <a class="btn btn-info" href="/monitoring/create">Внести данные</a>
                </div>
            </div>

            <div class="row text-center p-4">
                @can('viewAny', 'App\Models\DailyUse')
                    <div class="col-12 ">
                        <a class="btn btn-info" href="/phase/">Внести фазы хранения</a>
                    </div>
                @endcan
            </div>

        <div class="row text-center">
                <div class="col-12 ">
                    <a class="btn btn-success" href="/monitoring/reports/">Отчеты</a>
                </div>
        </div>

    </div>



@endsection('info')

