@extends('layouts.base')
@section('title', 'Пропуск на филиалы АФ-КРиММ')

@section('info')

    <div class="container gx-4">
        @can('PassFilial.completed.create')
            <div>
                <a class="btn btn-info" href="/pass/create">Создать</a>
            </div>
        @endcan

        @if(!empty($messages))
            <div class="mt-2"> {{$messages}}</div>
            @endif

        @forelse($passToDay as $pass)
            @if($loop->first)
                <table class="table table-bordered caption-top">
                    <caption>Выданные пропуска за {{\Illuminate\Support\Carbon::now()->format('d-m-Y')}}</caption>
                    <thead>
                    <tr style="text-align: center">
                        <th>Филиал</th>
                        <th>Гос номер</th>
                        <th>ФИО</th>
                        <th>Дата</th>
                        <th>Комментарий</th>
                        <th>Пропуск выдал</th>
                    </tr>
                    </thead>
            @endif
                    <tbody>
                    <tr style="text-align: center">
                        <td>Упоровский</td>
                        <td>{{$pass->number_car}}</td>
                        <td>{{$pass->last_name}}</td>
                        <td>{{\Illuminate\Support\Carbon::parse($pass->date)->format('d-m-Y')}}</td>
                        <td>{{$pass->comments}}</td>
                        <td>{{$fullName->Acronym($pass->Registration) . ' в ' . \Illuminate\Support\Carbon::parse($pass->created_at)->format('H:s d-m-Y')}}</td>
                    </tr>
                    </tbody>
            @if($loop->last)
                </table>
            @endif
        @empty
            <div class="mt-2">
                Пропуска на {{\Illuminate\Support\Carbon::now()->format('d-m-Y')}} не выдавались
            </div>

        @endforelse

    </div>
@endsection('info')
