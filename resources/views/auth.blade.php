@extends('layouts.base')
@section('title', 'Справочник')

@section('info')
            <form action="{{ route('fio.add') }}" method="POST">
                @csrf
                    <label for="txtFilial">Введите название ФИО</label>
                    <input name="fio" id="txtTitle" class="form-control @error('fio') is-invalid @enderror">
                @error('fio')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input type="submit" class="btn btn-primary" value="Сохранить">
            </form>
@endsection('info')
