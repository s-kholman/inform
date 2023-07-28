@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <div class="container">
    <div class="row">
        <form action="{{ route('limit.save') }}" method="post">
            @csrf
            <div class="col-5">

                <label>Фамилия</label>
                <input class="form-control" type="text" name="fio" value="{{$limit[0]->fio}}">

            </div>
            <div class="col-3">

            <label>Телефон</label>
            <input readonly class="form-control" type="text" name="phone" value="{{$limit[0]->phone}}">

            </div>
            <div class="col-2">

            <label>Лимит</label>
            <input class="form-control" type="text" name="limit"  value="{{$limit[0]->limit}}">

            </div>
           <br> <button class="btn btn-info" type="submit" name="saveLimit">Сохранить</button>
<a class="btn btn-info" href="/limit_add">Назад</a>
        </form>
    </div>
    </div>

        <div >
    <form action="{{ route('limit.destroy', ['limitID' => $limit[0]->id])}}" method="POST">
        @csrf
        @method('DELETE')
        <br><br><input type="submit" class="btn btn-danger" value="Удалить">
    </form>
        </div>

@endsection('info')
