@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
    <div class="col-3">
        <form action="{{ route($const['route'].'.update', [$const['route'] => $value->id]) }}" method="POST">
            @csrf
            @method('PATCH')
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
            <label for="comment">Коментарий</label>
            <input  name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror" value="{{$value->comment}}">
            @error('comment')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
            </span>
            @enderror
            <input type="submit" class="btn btn-primary" value="Сохранить">
        </form>
    </div>
    <div class="row-cols-4 p-5"><a class="btn btn-info" href="{{ url()->previous() }}">Назад</a></div>
    <form action="{{ route($const['route'].'.destroy', [$const['route'] => $value->id])}}" method="POST">
        @csrf
        @method('DELETE')
        <br><br><input type="submit" class="btn btn-danger" value="Удалить">
    </form>
@endsection('info')


