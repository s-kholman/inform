@extends('layouts.base')
@section('title', 'Внести новый данные по лимитам или детализацию')

@section('info')
    <div class="container">
        <div class="row">
<div class="col-5">
<form  action="{{ route('parser.save') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input class="form-control" type="file" name="pdf" accept="application/pdf">
    <button class="form-control" type="submit">Отправить</button>
</form>

</div>



    <div class="col-3">
    <form action="{{ route('limit.save') }}" method="post">
        @csrf
        <label>Фамилия</label>
        <input class="form-control" type="text" name="fio">
        <label>Телефон</label>
        <input class="form-control" type="text" name="phone">
        <label>Лимит</label>
        <input class="form-control" type="text" name="limit">
        <button class="form-control" type="submit" name="saveLimit">Сохранить</button>
    </form>
</div>
        </div>
    </div>
    <div class="col-sm">
        <table class="table">
            <th>Фио</th><th>Телефон</th><th>Лимит</th><th>Редактировать</th>
                @foreach($limit as $limit)
                <tr><td>{{ $limit->fio}}</td><td>{{$limit->phone}}</td><td>{{$limit->limit}}</td>
                    <td><a href="\edit_limit\{{$limit->id}}">Редактировать</a></td>

                </tr>
                @endforeach

        </table>

</div>




@endsection('info')
