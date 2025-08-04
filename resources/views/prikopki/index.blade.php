@extends('layouts.base')
@section('title', 'Текущие данные о прикопках ')

@section('info')


    <div class="container gx-4">
        <div class="row">

                <div class="col-4 p-3"><a class="btn btn-outline-success" href="{{route('prikopki.create')}}">Внести
                        прикопки</a></div>
            <div class="col-4 p-3">

            </div>

        </div>

        <div class="row">
            @forelse($prikopkis->groupBy('HarvestYear.name') as $year => $value)
                <a href="{{route('prikopki.showyear', ['year' => $year])}}">{{$year}}</a>
            @empty
            @endforelse
        </div>


    </div>
@endsection('info')
