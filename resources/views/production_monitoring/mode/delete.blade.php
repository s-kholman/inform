@extends('layouts.base')
@section('title', 'Удаление информации')

@section('info')
    @csrf
        <div class="container">

            <form action="{{ route('monitoring.mode.destroy', ['mode' => $mode->id])}}" method="POST">
             @csrf
                @method('DELETE')
                <div class="row">
                    <div class="col-12 text-center ">
                        <p><h2 class="text-danger">Вы действительно хотите удалить запись???</h2></p>
                        <p><h4 class="text-bg-light">{{\Carbon\Carbon::parse($mode->timeUp)->format('H:i')}} {{\Carbon\Carbon::parse($mode->timeDown)->format('H:i')}}</h4></p>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-4"></div>
                    <div class="col-2">
                        <input type="submit" class="btn btn-danger" value="Да">
                    </div>
                    <div class="col-1"></div>
                    <div class="col-2">
                        <a class="btn btn-info" href="{{ url(route('monitoring.show.filial.all', ['storage_name_id' => $mode->StorageName->storage_name_id, 'harvest_year_id' => $harvest_year_id])) }}">Нет</a>
                    </div>
                </div>
            </form>
        </div>
@endsection('info')
