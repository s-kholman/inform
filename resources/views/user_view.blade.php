@extends('layouts.base')
@section('title', 'Активация корпоративных пользователей')

@section('info')
    <div class="container">
        <table class="table table-bordered table-striped">
            <caption class="border rounded-3 p-3 caption-top"><p class="text-center"><b>Активация пользователей</b></p></caption>
            <thead>
            <th class="text-center">п/п</th><th class="text-center">ФИО</th><th class="text-center">E-mail</th><th class="text-center">Статус активации</th><th class="text-center">Редактирование</th>
            </thead>
            <tbody>
            @foreach($users as $value)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$value->Registration->last_name ?? 'н/д'}} {{$value->Registration->first_name ?? ''}} {{$value->Registration->middle_name ?? ''}}</td>
                    <td>{{$value->email}}

                    </td>
                    <td>
                        @if(\App\Models\Registration::where('user_id',$value->id)->first())
                            {{\App\Models\Registration::where('user_id',$value->id)->value('activation') ? 'Астивирован' : 'Расмотрение'}}
                    </td>
                    <td>
                        <a href="/user/{{$value->id}}">Активация</a>
                    </td>
                        @else
                            Расмотрение
                    </td>
                        <td>
                            Недоступно
                        </td>
                        @endif


                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection('info')
