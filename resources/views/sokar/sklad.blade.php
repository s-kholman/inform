@extends('layouts.base')
@section('title', 'Склад лаборотории - СОКАР')

@section('info')
 <p><h1>Остатки на складах:</h1></p>

    @forelse($arr as $value)
        @if ($loop->first)
            <table class="table table-bordered table-sm">
                <thead>
                <th>Наименование</th>
                <th>Размер</th>
                <th>Ростовка</th>
                <th>Цвет</th>
                <th>Кол-во</th>
                </thead>
                <tbody>
        @endif
        <tr>
            <td><a href="nomenklat/{{$value->id}}"> {{$value->SokarNomenklat->name}}</a></td>
            <td>{{$value->Size->name ?? '-'}}</td>
            <td>{{$value->Size->name ?? '-'}}</td>
            <td>{{$value->Color->name ?? '-'}}</td>
            <td>{{$value->count}}</td>
        </tr>


        @if($loop->last)
                </tbody>
            </table>
        @endif

    @empty
        <p>На складе ничего нет</p>
    @endforelse
 <a class="btn btn-info" href="/sokar">Назад</a>
@endsection('info')

