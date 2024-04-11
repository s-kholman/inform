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
                            {{\App\Models\Registration::where('user_id',$value->id)->value('activation') ? 'Активирован' : 'Расмотрение'}}
                    </td>
                    <td>
                        @can('viewAdmin', 'App\Models\Sowing')
                            <div class="col-2 p-1  dropdown">
                                <button type="button" class="btn btn-info dropdown-toggle " data-bs-toggle="dropdown">
                                    Действия
                                </button>
                                <ul class="dropdown-menu">
                                    <form action="{{ route('user.activation', ['registration' => $value->registration])}}" method="POST">
                                        @csrf
                                        <li><input type="submit" class="dropdown-item text-success" value="Активировать"></li>
                                    </form>

                                    <form action="{{ route('user.edit', ['registration' => $value->registration])}}" method="POST">
                                        @csrf
                                        <li><input class="dropdown-item text-info" type="submit" value="Редактировать"></li>
                                    </form>

                                    <form form class="delete-message" data-route="{{ route('user.activation.destroy', ['registration' => $value->registration])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <li><input type="submit" class="dropdown-item text-danger" value="Удалить"></li>
                                    </form>

                                </ul>
                            </div>

                        @endcan
                    </td>
                        @else
                            Не заполнен профиль
                    </td>
                        <td>
                            <form action="{{ route('user.activation.forceDelete', ['user' => $value])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <li><input type="submit" class="btn btn-danger" value="Удалить без возвратно"></li>
                            </form>
                        </td>
                        @endif


                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection('info')
@section('script')
    @include('scripts\destroy-modal')
@endsection
