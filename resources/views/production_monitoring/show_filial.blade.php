@extends('layouts.base')
@section('title', 'Места хранения')

@section('info')
    <div class="container">

            <div class="row p-5">
                <div class="col-2">
                    <a class="btn btn-info" href="/monitoring/">Назад</a>
                </div>
                @canany(['ProductMonitoring.director.create', 'ProductMonitoring.completed.create'])
                    <div class="col-sm-4 ">
                        <a class="btn btn-info" href="/monitoring/create">Внести данные</a>
                    </div>
                @endcanany
            </div>

        <div class="row">
            <div class="col-8">
                @foreach($monitoring as $value)
                    @if($loop->first)
                        <h5><p>Филиал: {{$value->filial->name}}</p></h5><br>
                    @endif

                    <h5><p>
                            <a href="/monitoring/filial/storage/{{$value->storage_name_id}}/year/{{$value->harvest_year_id}}">{{$value->name}}</a>
                        </p></h5><br>
                    @if($loop->last)
                        @if($value->storageName->filial_id == 11)
            </div>

            @endif
            @endif
            @endforeach

        </div>

    </div>
@endsection('info')

