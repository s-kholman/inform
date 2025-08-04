@extends('layouts.base')
@section('title', 'Текущие данные о прикопках ')

@section('info')
    <div class="container gx-4">
        <div class="row">

            <table class="table table-bordered">
                <caption class="caption-top text-center">Прикопки на поле: <b>{{--{{$pole_name}}--}}</b></caption>
                <thead>
                <tr>
                    @foreach($prikopkis->groupBy('filial.name') as $filial => $value)
                        <th>{{$filial}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr>
                @forelse($prikopkis->groupBy('filial.name') as $filial => $value)
                        <td>
                    @foreach($value->groupBy('sevooborot.pole.name') as $pole => $info)
                                <a href="/prikopki/year/{{$info[0]->harvest_year_id}}/pole/{{$info[0]->sevooborot->pole_id}}" >{{$info[0]->sevooborot->pole->name}}</a><br />
                    @endforeach
                        </td>
                @empty
                @endforelse
                </tr>
                </tbody>
            </table>
        </div>
        <a class="btn btn-info" href="/prikopki">Назад</a>
    </div>
@endsection('info')
@section('script')
    @include('scripts\destroy-modal')
@endsection
