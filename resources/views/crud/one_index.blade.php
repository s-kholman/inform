@extends('layouts.base')
@section('title',$const['title'])

@section('info')
    <div class="col-3">
            <form action="{{ route($const['route'].'.store') }}" method="POST">
                @csrf
                    <label for="txt">{{$const['label']}}</label>
                    <input name="name" id="txt" class="form-control @error($const['error']) is-invalid @enderror">
                @error($const['error'])
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
@endsection('info')
