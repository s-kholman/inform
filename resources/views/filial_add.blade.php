@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
            <form action="{{ route('filial.add') }}" method="POST">
                @csrf
                    <label for="txtFilial">Введите название филиала</label>
                    <input name="filial" id="txtTitle" class="form-control @error('filial') is-invalid @enderror">
                @error('filial')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>
@endsection('info')
