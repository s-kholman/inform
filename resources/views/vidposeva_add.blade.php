@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
            <form action="{{ route('vidposeva.add') }}" method="POST">
                @csrf
                    <label for="txtvidposeva">Введите название вида посева</label>
                    <input name="vidposeva" id="txtTitle" class="form-control @error('vidposeva') is-invalid @enderror">
                @error('vidposeva')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>
@endsection('info')
