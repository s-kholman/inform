@extends('layouts.base')
@section('title',$const['title'])

@section('info')
    <div class="container">
        <form action="{{ route($const['route'].'.store') }}" method="POST">
        <div class="row">
            <div class="col-3">
                    @csrf
                    <label for="txt">{{$const['label']}}</label>
                    <input name="name" id="txt" class="form-control @error('name') is-invalid @enderror">
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
                    <a class="btn btn-primary" href="/">Назад</a>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-6">
                @forelse($value as $value)
                    <a href="\{{$const['route']}}\{{$value->id}}\edit">{{$value->name}}</a> <br>
                @empty
                @endforelse
            </div>
        </div>

    </div>



@endsection('info')
