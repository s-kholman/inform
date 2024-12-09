@extends('layouts.base')
@section('title', 'Текущие данные по лимитам')

@section('info')
    <div class="container">
        <div class="d-grid gap-2 d-md-block">
            <a class="btn btn-info" href="\communication\create\">Добавить</a>
        </div>
        <div class="col-sm">
            <table class="table">
                <th>Фио</th>
                <th>Телефон</th>
                <th>Лимит</th>
                <th>Редактировать</th>
                @foreach($limit as $limit)
                    <tr>
                        <td>{{$limit->fio}}</td>
                        <td>{{$limit->phone}}</td>
                        <td>{{$limit->limit}}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button"
                                        class="btn btn-sm btn-outline-info dropdown-toggle"
                                        data-bs-toggle="dropdown">
                                    Действия
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="button btn dropdown-item" href="\communication\{{$limit->id}}\edit\">Редактировать</a>
                                    </li>
                                    <form
                                        class="delete-message"
                                        data-route="{{ route('communication.destroy', ['communication' => $limit->id])}}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <li>
                                            <input type="submit"
                                                   class="dropdown-item text-danger"
                                                   value="Удалить">
                                        </li>
                                    </form>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection('info')
@section('script')
    @include('scripts\destroy-modal')
@endsection
