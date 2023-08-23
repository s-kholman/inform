@extends('layouts.base')
@section('title',$const['title'])

@section('info')
    <div class="col-3">
        <form action="{{ route($const['route'].'.store') }}" method="POST">
            @csrf
            <label for="txt">{{$const['label']}}</label>
            <input name="name" id="txt" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
            </span>
            @enderror
            <input type="submit" class="btn btn-primary" value="Сохранить">
        </form>
    </div>
    @forelse($value as $value)
        <a href="\{{$const['route']}}\{{$value->id}}\edit">{{$value->name}}</a> <br>
    @empty
    @endforelse
    <div class="row-cols-4 p-5"><a class="btn btn-info" href="/">Назад</a></div>
@endsection('info')
