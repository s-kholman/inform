@extends('layouts.base')
@section('title', 'Текущие данные об опрыскивание ')

@section('info')

    <table class="table table-bordered">
        <thead>
        <th>Дата</th>
        <th>Культура</th>
        <th>Препарат</th>
        <th>Дозировка</th>
        <th>Объем</th>
        <th>Комментарий</th>
        </thead>
        <caption class="caption-top">
            {{$pole_name}}
        </caption>

        @forelse($spraying as $value)
            <tr>
                <td><a href="/spraying/{{$value->id}}/edit">{{\Carbon\Carbon::parse($value->date)->translatedFormat('d-m-Y')}}</a></td>
                <td>{{$value->Cultivation->name}} {{$value->Nomenklature->name}} {{$value->Reproduktion->name ?? null }} ({{$value->Sevooborot->square}} Га)</td>
                <td>{{$value->szr->name}}</td>
                <td>{{$value->doza}}</td>
                <td>{{$value->volume}}</td>
                <td>{{$value->comments}}</td>
            </tr>
        @empty

        @endforelse

    </table>

    <a class="btn btn-info" href="/spraying">Назад</a>






@endsection('info')
