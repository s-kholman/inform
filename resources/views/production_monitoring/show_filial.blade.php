@extends('layouts.base')
@section('title', 'Места хранения')

@section('info')
    <div class="container">

        @foreach($monitoring as $value)
            @if($loop->first)
                <h5><p>Филиал: {{\App\Models\filial::where('id', $value->storageName->filial_id)->value('name')}}</p></h5><br>
            @endif

            <h5><p><a href="/monitoring/filial/all/{{$value->storage_name_id}}/">{{$value->storageName->name}}</a></p></h5><br>
        @endforeach

            <div class="row p-5">
                <div class="col-2">
                    <a class="btn btn-info" href="/monitoring/">Назад</a>
                </div>

                <div class="col-3 ">
                    <a class="btn btn-info" href="/monitoring/create">Внести данные</a>
                </div>
            </div>
    </div>
@endsection('info')

