@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
            <form action="{{ route('agregat.add') }}" method="POST">
                @csrf
                    <label for="txtAgregat">Введите название агрегата</label>
                    <input name="agregat" id="txtTitle" class="form-control @error('agregat') is-invalid @enderror">
                @error('agregat')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>
@endsection('info')
