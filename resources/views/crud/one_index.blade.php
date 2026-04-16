@extends('layouts.base')
@section('title',$const['title'])

@section('info')
    <div class="container">
        <form action="{{ route($const['route'].'.store') }}" method="POST">
        <div class="row">
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-3 col-xxl-3">
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
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                @forelse($value as $value)
                    <a href="\{{$const['route']}}\{{$value->id}}\edit">{{$value->name}}</a> <br>
                @empty
                @endforelse
            </div>
        </div>

    </div>



@endsection('info')
