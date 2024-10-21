@extends('layouts.base')
@section('title', 'Роли & Права')

@section('info')
<div class="container">
    <form action="{{route('role.store')}}" method="post">
        <div class="col-sm-6">
            @csrf
            <label for="model">Введите название модели</label>
            <input name="model" id="model"
                   class="form-control @error('model') is-invalid @enderror">
            @error('model')
            <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-sm-4 mt-4">
            @forelse($roles as $key => $value)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{$key}}" name="roles[]" id="{{$key}}">
                    <label class="form-check-label" for="{{$key}}">
                        {{$value}}
                    </label>
                </div>
            @empty
            @endforelse
            <div>
                <label class="form-control @error('roles') is-invalid @enderror">
                    @error('roles')
                    <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </label>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>

@endsection('info')

