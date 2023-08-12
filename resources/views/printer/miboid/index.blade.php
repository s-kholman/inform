@extends('layouts.base')
@section('title',$const['title'])

@section('info')
    <div class="col-3">
        <form action="{{route('mibOid.store')}}" method="POST">
            @csrf
            <label for="txt">{{$const['label']}}</label>
            <input name="name" id="txt" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
            </span>
            @enderror
            <label for="comment">Коментарий</label>
            <input name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror">
            @error('comment')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
            </span>
            @enderror
            <input type="submit" class="btn btn-primary" value="Сохранить">
        </form>
    </div>
    @forelse($value as $value)
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <a href="\{{$const['route']}}\{{$value->id}}\edit">{{$value->name}}</a> <br>
                </div>
                <div class="col-5">
                    {{$value->comment}}
                </div>
            </div>
        </div>

    @empty
    @endforelse
@endsection('info')
