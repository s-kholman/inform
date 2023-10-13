@extends('layouts.base')
@section('title', 'Мониторинг температуры в боксах')

@section('info')
    <div class="container">
        <div class="row  text-center">
            <div class="col-12 p-5">
                <p><h4>Отчет по температуре хранения продукции по боксам:</h4></p>
            </div>
        </div>

        @forelse($sort as $value)
            @if ($loop->first)
                <div class="row text-center">
                    <div class="col-4 p-6"></div><div class="text-center"><h5>Филиалы:</h5></div>
                </div>
                <div class="row text-center p-5">
            @endif
                    <div class="col-12"><h4><p><a href="{{route('monitoring.show.filial', ['id' => $value])}}">{{\App\Models\filial::where('id', $value)->value('name')}}</a></p></h4></div>
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

    </div>



@endsection('info')

