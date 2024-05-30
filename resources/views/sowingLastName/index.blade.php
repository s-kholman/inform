@extends('layouts.base')
@section('title', 'Справочник - ФИО')

@section('info')

    <div class="col-3">
        <a class="btn btn-info" href="sowingLastName/create">Добавить ФИО</a>
    </div>


    @forelse($sowingLastNames as $sowingLastName)
        @if($loop->first)
            <table class="table table-bordered">
                <tr>
                    <th>ФИО</th>
                    <th>Филиал</th>
                    <th>Действия</th>
                </tr>
                @endif
                <tr>
                    <td>{{$sowingLastName->name}}</td>
                    <td>{{$sowingLastName->filial->name ?? ''}}</td>
                    <td><a href="#">Действие</a></td>
                </tr>
                @if($loop->last)
            </table>
        @endif
    @empty
        <p>Данные не найдены</p>
    @endforelse


@endsection('info')
