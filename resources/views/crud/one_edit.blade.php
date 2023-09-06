@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <div class="container">
        <form action="{{ route($const['route'].'.update', [$const['route'] => $value->id]) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-4">
                    <label for="txt">{{$const['label']}}</label>
                    <input value="{{$value->name}}"
                           name="name"
                           id="txt"
                           class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>
            <div class="row p-3">
                <div class="col-2">
                    <input type="submit" class="btn btn-success" value="Сохранить">
                </div>
                <div class="col-1">
                    <a class="btn btn-primary" href="/{{$const['route']}}">Назад</a>
                </div>
            </div>
        </form>
        <div class="row p-3">
            <div class="col-4">
                <form action="{{ route($const['route'].'.destroy', [$const['route'] => $value->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <br><br><input type="submit" class="btn btn-danger" value="Удалить">
                </form>
            </div>
        </div>


    </div>
@endsection('info')


