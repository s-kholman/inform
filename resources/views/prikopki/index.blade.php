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


        <div class="container gx-4">
            <div class="row">
                @forelse($prikopkis as $filial_name => $prikopki)
                    <div class="col border border-1 text-center">
                        {{$filial_name}}
                    </div>
                @empty
                    <div class="col-xl-10">
                        <div class="row">
                            Информация о прикопках не найдена
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="row">
                @forelse($prikopkis as $filial_name => $prikopki)
                    <div class="col border border-1 text-center">
                        @foreach($prikopki->groupBy('sevooborot.pole.name') as $pole)
                            <a href="/prikopki/{{$pole[0]->sevooborot->pole_id}}" >{{$pole[0]->sevooborot->pole->name}}</a><br />
                        @endforeach
                    </div>
                @empty
                @endforelse
            </div>

        </div>
    </div>
@endsection('info')
