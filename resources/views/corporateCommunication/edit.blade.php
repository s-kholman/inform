@extends('layouts.base')
@section('title', 'Редактирование данных')

@section('info')
    <div class="container">
        <form action="{{ route('communication.update', ['communication' => $detail->id]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <label for="fio" class="col-sm-2 col-form-label">ФИО</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="fio" id="fio" value="{{$detail->fio}}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="phone" class="col-sm-2 col-form-label">Телефон</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="phone" id="phone" value="{{$detail->phone}}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="limit" class="col-sm-2 col-form-label">Лимит</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="limit" id="limit" value="{{$detail->limit}}">
                </div>
            </div>

            <div class="d-grid gap-2 d-md-block">
                <button class="btn btn-info me-md-4" type="submit" name="saveLimit">Сохранить</button>
                <a class="btn btn-info" href="/communication">Назад</a>
            </div>
        </form>
    </div>
@endsection('info')
