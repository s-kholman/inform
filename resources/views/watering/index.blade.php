@extends('layouts.base')

@section('title', 'Данные о поливе ')

@section('info')
    <div class="container">
        <div class="row">
            @forelse($pole as $filial_name => $pole)
                <div class="col">
                    <b>{{$filial_name}}</b>
                    @foreach($pole as $pole_name => $temp)
                        <br><a href="/watering/show/{{$temp[0]->filial_id}}/{{$temp[0]->pole_id}}">{{$pole_name}}</a>
                    @endforeach
                </div>
            @empty
            @endforelse
        </div>
        <div class="m-5 row">
            <div class="col">
                <a class="btn btn-outline-success" href="/watering/create">Внести полив</a>
            </div>
        </div>
    </div>
@endsection('info')
